<!-- Edit Cart Modal -->
<div class="modal fade" id="editCartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Chỉnh sửa món</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body px-4 pt-0">
        <div class="row g-0">
          <div class="col-md-5 text-center">
            <img id="editModalImage" class="rounded-3 mb-3" src="" alt="" width="100%" style="object-fit:cover; max-height:350px;">
            <label class="fw-bold mb-2 d-block">Mô tả món ăn:</label>
            <p id="editModalDescription"></p>
          </div>
          <div class="col-md-7 ps-md-4">
            <h4 id="editModalName" class="fw-bold mb-1"></h4>
            <p class="text-primary fw-bold fs-5 mb-3">
              <span id="editModalPrice"></span>đ
            </p>

            <div id="editSizeSection" class="mb-3" style="display:none;">
              <label class="fw-bold mb-2 d-block">Chọn size <span class="text-danger">*</span></label>
              <div class="option-grid" id="editSizeOptions"></div>
            </div>

            <div id="editToppingSection" class="mb-3" style="display:none;">
              <label class="fw-bold mb-2 d-block">Thêm topping</label>
              <div class="option-grid" id="editToppingOptions"></div>
            </div>

            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
              <button type="button" class="btn btn-sm rounded-circle bg-light border" id="editQtyMinus" style="width:36px;height:36px;">
                <i class="fa fa-minus" style="color:#424242;"></i>
              </button>
              <input type="text" id="editQtyInput" class="form-control form-control-sm text-center border-0 fw-bold fs-5" value="1" readonly style="width:100px;">
              <button type="button" class="btn btn-sm rounded-circle bg-light border" id="editQtyPlus" style="width:36px;height:36px;">
                <i class="fa fa-plus" style="color:#424242;"></i>
              </button>
            </div>

            <div class="d-flex justify-content-between align-items-center bg-light rounded p-3 mb-3">
              <span class="fw-bold">Tổng tiền:</span>
              <span class="fw-bold text-primary fs-5"><span id="editModalTotal"></span>đ</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 px-4 pb-4">
        <input type="hidden" id="editCartId">
        <input type="hidden" id="editFoodId">
        <input type="hidden" id="editSizeHidden" value="">
        <input type="hidden" id="editToppingsHidden" value="[]">
        <button type="button" id="btnUpdateCart" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
          <i class="fas fa-save me-2"></i>Cập nhật giỏ hàng
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Toast thông báo -->
<div id="cart-edit-toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;">
    <div class="alert alert-success shadow-lg d-flex align-items-center" role="alert" style="min-width:280px;border-radius:12px;">
        <i class="fas fa-check-circle me-2 fs-4"></i>
        <div class="flex-grow-1">
            <span id="cart-edit-toast-msg">Cập nhật thành công!</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editCartModal');
    var editImage = document.getElementById('editModalImage');
    var editName = document.getElementById('editModalName');
    var editDesc = document.getElementById('editModalDescription');
    var editPrice = document.getElementById('editModalPrice');
    var editTotal = document.getElementById('editModalTotal');
    var editCartId = document.getElementById('editCartId');
    var editFoodId = document.getElementById('editFoodId');
    var editQtyInput = document.getElementById('editQtyInput');
    var editSizeHidden = document.getElementById('editSizeHidden');
    var editToppingsHidden = document.getElementById('editToppingsHidden');
    var editSizeSection = document.getElementById('editSizeSection');
    var editToppingSection = document.getElementById('editToppingSection');
    var editSizeOptions = document.getElementById('editSizeOptions');
    var editToppingOptions = document.getElementById('editToppingOptions');
    var btnUpdate = document.getElementById('btnUpdateCart');

    var editCurrentPrice = 0;
    var preSelectedSizeId = '';
    var preSelectedToppingIds = [];

    function formatNumber(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function editUpdateTotal() {
        var qty = parseInt(editQtyInput.value) || 1;
        var sizePrice = 0;
        var toppingPrice = 0;

        var checkedSize = document.querySelector('#editSizeOptions input[name="edit_size"]:checked');
        if (checkedSize) {
            sizePrice = parseInt(checkedSize.getAttribute('data-price')) || 0;
            editSizeHidden.value = checkedSize.value;
        } else {
            editSizeHidden.value = '';
        }

        var checkedToppings = document.querySelectorAll('#editToppingOptions input[name="edit_topping[]"]:checked');
        var tIds = [];
        checkedToppings.forEach(function(el) {
            toppingPrice += parseInt(el.getAttribute('data-price')) || 0;
            tIds.push(el.value);
        });
        editToppingsHidden.value = JSON.stringify(tIds);

        var total = (editCurrentPrice + sizePrice + toppingPrice) * qty;
        editTotal.textContent = formatNumber(total);
    }

    function renderEditSizes(sizes) {
        editSizeOptions.innerHTML = '';
        if (!sizes || sizes.length === 0) {
            editSizeSection.style.display = 'none';
            return;
        }
        editSizeSection.style.display = 'block';
        sizes.forEach(function(sz) {
            var checked = (String(sz.id) === String(preSelectedSizeId)) ? ' checked' : '';
            var div = document.createElement('div');
            div.className = 'option-box';
            div.innerHTML =
                '<input type="radio" name="edit_size" data-price="' + sz.price + '" id="edit_size_' + sz.id + '" value="' + sz.id + '"' + checked + '>' +
                '<label for="edit_size_' + sz.id + '">' +
                    '<div class="fw-bold">' + sz.name + '</div>' +
                    '<small>+' + formatNumber(sz.price) + 'đ</small>' +
                '</label>';
            editSizeOptions.appendChild(div);
        });
        editSizeOptions.querySelectorAll('input').forEach(function(el) {
            el.addEventListener('change', editUpdateTotal);
        });
    }

    function renderEditToppings(toppings) {
        editToppingOptions.innerHTML = '';
        if (!toppings || toppings.length === 0) {
            editToppingSection.style.display = 'none';
            return;
        }
        editToppingSection.style.display = 'block';
        toppings.forEach(function(tp) {
            var checked = (preSelectedToppingIds.indexOf(String(tp.id)) !== -1) ? ' checked' : '';
            var div = document.createElement('div');
            div.className = 'option-box';
            div.innerHTML =
                '<input type="checkbox" name="edit_topping[]" data-price="' + tp.price + '" id="edit_tp_' + tp.id + '" value="' + tp.id + '"' + checked + '>' +
                '<label for="edit_tp_' + tp.id + '">' +
                    '<span>' + tp.name + '</span>' +
                    '<b>+' + formatNumber(tp.price) + 'đ</b>' +
                '</label>';
            editToppingOptions.appendChild(div);
        });
        editToppingOptions.querySelectorAll('input').forEach(function(el) {
            el.addEventListener('change', editUpdateTotal);
        });
    }

    function showEditToast(msg, isError) {
        var toast = document.getElementById('cart-edit-toast');
        var msgEl = document.getElementById('cart-edit-toast-msg');
        var alertDiv = toast.querySelector('.alert');

        msgEl.textContent = msg;
        alertDiv.className = 'alert shadow-lg d-flex align-items-center';
        alertDiv.classList.add(isError ? 'alert-danger' : 'alert-success');

        toast.style.display = 'block';
        setTimeout(function() { toast.style.display = 'none'; }, 4000);
    }

    editModal.addEventListener('show.bs.modal', function(e) {
        var trigger = e.relatedTarget;
        if (!trigger) return;

        editCartId.value = trigger.getAttribute('data-cart-id');
        editFoodId.value = trigger.getAttribute('data-food-id');
        editName.textContent = trigger.getAttribute('data-food-name');
        editDesc.textContent = trigger.getAttribute('data-food-description') || '';
        editCurrentPrice = parseInt(trigger.getAttribute('data-food-price')) || 0;
        editPrice.textContent = formatNumber(editCurrentPrice);
        editImage.src = trigger.getAttribute('data-food-image');
        editImage.alt = trigger.getAttribute('data-food-name');
        editQtyInput.value = parseInt(trigger.getAttribute('data-cart-quantity')) || 1;

        preSelectedSizeId = trigger.getAttribute('data-cart-size-id') || '';
        try {
            preSelectedToppingIds = JSON.parse(trigger.getAttribute('data-cart-topping-ids') || '[]').map(String);
        } catch(ex) {
            preSelectedToppingIds = [];
        }

        editSizeHidden.value = preSelectedSizeId;
        editToppingsHidden.value = JSON.stringify(preSelectedToppingIds);

        editSizeSection.style.display = 'none';
        editToppingSection.style.display = 'none';
        editSizeOptions.innerHTML = '<div class="text-muted">Đang tải...</div>';
        editToppingOptions.innerHTML = '';

        editUpdateTotal();

        var foodId = trigger.getAttribute('data-food-id');
        fetch('{{ APP_URL }}food/' + foodId + '/options')
            .then(function(res) { return res.json(); })
            .then(function(data) {
                renderEditSizes(data.sizes || []);
                renderEditToppings(data.toppings || []);
                editUpdateTotal();
            })
            .catch(function() {
                editSizeSection.style.display = 'none';
                editToppingSection.style.display = 'none';
            });
    });

    document.getElementById('editQtyMinus').addEventListener('click', function() {
        var qty = parseInt(editQtyInput.value) || 1;
        if (qty > 1) {
            editQtyInput.value = qty - 1;
            editUpdateTotal();
        }
    });

    document.getElementById('editQtyPlus').addEventListener('click', function() {
        var qty = parseInt(editQtyInput.value) || 1;
        editQtyInput.value = qty + 1;
        editUpdateTotal();
    });

    btnUpdate.addEventListener('click', function() {
        var btn = this;

        var hasSizes = editSizeSection.style.display !== 'none';
        if (hasSizes && !editSizeHidden.value) {
            showEditToast('Vui lòng chọn size!', true);
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang cập nhật...';

        var cartId = editCartId.value;
        var formData = new FormData();
        formData.append('quantity', editQtyInput.value);

        if (editSizeHidden.value) {
            formData.append('size_id', editSizeHidden.value);
        }

        var toppingIds = [];
        try { toppingIds = JSON.parse(editToppingsHidden.value); } catch(ex) {}
        toppingIds.forEach(function(id) {
            formData.append('topping_ids[]', id);
        });

        fetch('{{ APP_URL }}cart/' + cartId + '/update', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                bootstrap.Modal.getInstance(editModal).hide();
                showEditToast(data.message || 'Cập nhật thành công!');
                setTimeout(function() { location.reload(); }, 1000);
            } else {
                showEditToast('Có lỗi xảy ra, vui lòng thử lại!', true);
            }
        })
        .catch(function() {
            showEditToast('Có lỗi xảy ra!', true);
        })
        .finally(function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save me-2"></i>Cập nhật giỏ hàng';
        });
    });
});
</script>
@endpush
