<!-- Food Detail Modal -->
<div class="modal fade" id="foodModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body text-center px-4 pt-0">
        <img id="modalFoodImage" class="rounded-circle mb-3" src="" alt="" width="150" height="150" style="object-fit:cover;">
        <h4 id="modalFoodName" class="fw-bold mb-1"></h4>
        <p class="text-primary fw-bold fs-5 mb-4">
          <span id="modalFoodPrice"></span>đ
        </p>

        <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
          <button type="button" class="btn btn-sm rounded-circle bg-light border" id="modalQtyMinus" style="width:36px;height:36px;">
            <i class="fa fa-minus" style="color:#424242;"></i>
          </button>
          <input type="text" id="modalQtyInput" class="form-control form-control-sm text-center border-0 fw-bold fs-5" value="1" readonly style="width:100px;">
          <button type="button" class="btn btn-sm rounded-circle bg-light border" id="modalQtyPlus" style="width:36px;height:36px;">
            <i class="fa fa-plus" style="color:#424242;"></i>
          </button>
        </div>

        <div class="d-flex justify-content-between align-items-center bg-light rounded p-3 mb-3">
          <span class="fw-bold">Tổng tiền:</span>
          <span class="fw-bold text-primary fs-5"><span id="modalTotal"></span>đ</span>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 px-4 pb-4">
        <form action="{{ APP_URL }}cart/add" method="POST" class="w-100">
          <input type="hidden" name="food_id" id="modalFoodId">
          <input type="hidden" name="quantity" id="modalQtyHidden" value="1">
          <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
            <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var foodModal = document.getElementById('foodModal');
  var modalImage = document.getElementById('modalFoodImage');
  var modalName = document.getElementById('modalFoodName');
  var modalPrice = document.getElementById('modalFoodPrice');
  var modalTotal = document.getElementById('modalTotal');
  var modalFoodId = document.getElementById('modalFoodId');
  var modalQtyInput = document.getElementById('modalQtyInput');
  var modalQtyHidden = document.getElementById('modalQtyHidden');
  var btnMinus = document.getElementById('modalQtyMinus');
  var btnPlus = document.getElementById('modalQtyPlus');
  var currentPrice = 0;

  function formatNumber(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function updateTotal() {
    var qty = parseInt(modalQtyInput.value) || 1;
    modalTotal.textContent = formatNumber(currentPrice * qty);
    modalQtyHidden.value = qty;
  }

  foodModal.addEventListener('show.bs.modal', function(e) {
    var trigger = e.relatedTarget;
    if (!trigger) return;

    modalFoodId.value = trigger.getAttribute('data-food-id');
    modalName.textContent = trigger.getAttribute('data-food-name');
    currentPrice = parseInt(trigger.getAttribute('data-food-price'));
    modalPrice.textContent = formatNumber(currentPrice);
    modalImage.src = trigger.getAttribute('data-food-image');
    modalImage.alt = trigger.getAttribute('data-food-name');
    modalQtyInput.value = 1;
    updateTotal();
  });

  btnMinus.addEventListener('click', function() {
    var qty = parseInt(modalQtyInput.value) || 1;
    if (qty > 1) {
      modalQtyInput.value = qty - 1;
      updateTotal();
    }
  });

  btnPlus.addEventListener('click', function() {
    var qty = parseInt(modalQtyInput.value) || 1;
    modalQtyInput.value = qty + 1;
    updateTotal();
  });
});
</script>
