<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tóm tắt biên lai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body px-4 pt-0">
                <div class="bg-light rounded p-3 mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Số món</span>
                        <span class="fw-bold" id="checkoutItemCount">{{ count($carts) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Tổng tiền</span>
                        <span class="fw-bold text-primary" id="checkoutTotal">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <hr class="my-2">
                    <div class="mb-2">
                        <div class="text-muted" style="font-size:12px;">Tên</div>
                        <div class="fw-bold" id="checkoutNamePreview"></div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted" style="font-size:12px;">Số điện thoại</div>
                        <div class="fw-bold" id="checkoutPhonePreview"></div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted" style="font-size:12px;">Địa chỉ</div>
                        <div class="fw-bold" id="checkoutAddressPreview"></div>
                    </div>
                    <div class="mb-0">
                        <div class="text-muted" style="font-size:12px;">Order Notes (optional)</div>
                        <div class="fw-bold" id="checkoutNotesPreview"></div>
                    </div>
                </div>

                <div class="mb-2 fw-bold">Chọn phương thức thanh toán</div>
                <div class="option-grid" style="grid-template-columns: repeat(2, 1fr);">
                    <div class="option-box">
                        <input class="form-check-input" type="radio" name="checkout_payment" id="pay_cash" value="Cash" checked>
                        <label for="pay_cash" class="w-100">
                            <span>💵 Tiền mặt</span>
                        </label>
                    </div>
                    <div class="option-box">
                        <input class="form-check-input" type="radio" name="checkout_payment" id="pay_transfer_qr" value="Transfer_QR">
                        <label for="pay_transfer_qr" class="w-100">
                            <span>🏦 Chuyển khoản QR</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-danger fw-bold" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary fw-bold" id="btnConfirmCheckout">
                    Xác nhận đặt hàng
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Toast -->
<div id="checkout-toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;cursor:pointer;"
    onclick="window.location.href='{{ APP_URL }}cart'">
    <div class="alert alert-success shadow-lg d-flex align-items-center" role="alert" style="min-width:280px;border-radius:12px;">
        <i class="fas fa-check-circle me-2 fs-4"></i>
        <div class="flex-grow-1">
            <span id="checkout-toast-msg">Đặt hàng thành công!</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnCheckout = document.getElementById('btnCheckout');
        var checkoutModalEl = document.getElementById('checkoutModal');
        var checkoutModal = new bootstrap.Modal(checkoutModalEl);
        var btnConfirm = document.getElementById('btnConfirmCheckout');

        var namePreview = document.getElementById('checkoutNamePreview');
        var phonePreview = document.getElementById('checkoutPhonePreview');
        var addressPreview = document.getElementById('checkoutAddressPreview');
        var notesPreview = document.getElementById('checkoutNotesPreview');

        var toast = document.getElementById('checkout-toast');
        var toastMsg = document.getElementById('checkout-toast-msg');
        var toastAlert = toast.querySelector('.alert');

        function showCheckoutToast(msg, isError) {
            toastMsg.textContent = msg;
            toastAlert.className = 'alert shadow-lg d-flex align-items-center';
            toastAlert.classList.add(isError ? 'alert-danger' : 'alert-success');
            toast.style.cursor = isError ? 'default' : 'pointer';
            toast.onclick = isError ? null : function() {
                window.location.href = '{{ APP_URL }}order/history';
            };
            toast.style.display = 'block';
            if (!isError) {
                setTimeout(function() {
                    toast.style.display = 'none';
                    window.location.href = '{{ APP_URL }}order/history';
                }, 3000);
            } else {
                setTimeout(function() {
                    toast.style.display = 'none';
                }, 4000);
            }
        }

        // Hàm xóa lỗi validation khi người dùng nhập lại
        function clearValidationError(inputEl) {
            inputEl.classList.remove('is-invalid');
            var feedback = inputEl.parentNode.querySelector('.invalid-feedback');
            if (feedback) feedback.remove();
        }

        // Hàm hiển thị lỗi validation
        function showValidationError(inputEl, message) {
            inputEl.classList.add('is-invalid');
            var existingFeedback = inputEl.parentNode.querySelector('.invalid-feedback');
            if (existingFeedback) existingFeedback.remove();
            var feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = message;
            inputEl.parentNode.appendChild(feedback);
        }

        // Gắn sự kiện xóa lỗi khi nhập
        ['checkoutName', 'checkoutPhone', 'checkoutAddress'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', function() { clearValidationError(el); });
            }
        });

        btnCheckout.addEventListener('click', function() {
            var nameEl = document.getElementById('checkoutName');
            var phoneEl = document.getElementById('checkoutPhone');
            var addressEl = document.getElementById('checkoutAddress');
            var notesEl = document.getElementById('checkoutNotes');

            var nameVal = nameEl ? nameEl.value.trim() : '';
            var phoneVal = phoneEl ? phoneEl.value.trim() : '';
            var addressVal = addressEl ? addressEl.value.trim() : '';
            var notesVal = notesEl ? notesEl.value.trim() : '';

            // Validate
            var isValid = true;
            var phoneRegex = /^(0|\+84)(3|5|7|8|9)[0-9]{8}$/;

            // Clear previous errors
            [nameEl, phoneEl, addressEl].forEach(function(el) {
                if (el) clearValidationError(el);
            });

            if (!nameVal) {
                showValidationError(nameEl, 'Vui lòng nhập tên khách hàng.');
                isValid = false;
            }

            if (!phoneVal) {
                showValidationError(phoneEl, 'Vui lòng nhập số điện thoại.');
                isValid = false;
            } else if (!phoneRegex.test(phoneVal)) {
                showValidationError(phoneEl, 'Số điện thoại không hợp lệ (VD: 0912345678).');
                isValid = false;
            }

            if (!addressVal) {
                showValidationError(addressEl, 'Vui lòng nhập địa chỉ giao hàng.');
                isValid = false;
            }

            if (!isValid) return;

            namePreview.textContent = nameVal;
            phonePreview.textContent = phoneVal;
            addressPreview.textContent = addressVal;
            notesPreview.textContent = notesVal || 'Không có';

            checkoutModal.show();
        });

        btnConfirm.addEventListener('click', function() {
            var btn = this;
            var selectedPayment = document.querySelector('input[name="checkout_payment"]:checked');
            var paymentVal = selectedPayment ? selectedPayment.value : 'Cash';

            if (paymentVal === 'Transfer_QR') {
                showCheckoutToast('Chuyển khoản QR đang trong quá trình thêm.', true);
                return;
            }

            // Disable button and show loading
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';

            // Submit via AJAX
            var form = document.getElementById('checkoutForm');
            var formData = new FormData(form);
            formData.append('checkout_payment', paymentVal);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(function() {
                // Close modal
                checkoutModal.hide();

                // Show success toast
                showCheckoutToast('🎉 Đặt hàng thành công! Cảm ơn bạn.', false);

                // Clear cart table rows
                var cartTbody = document.querySelector('.cart-table tbody');
                if (cartTbody) cartTbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-4"><i class="fas fa-shopping-cart me-2"></i>Giỏ hàng trống</td></tr>';

                // Reset total
                var grandTotal = document.getElementById('grandTotal');
                if (grandTotal) grandTotal.textContent = '0đ';

                // Update cart badge
                var badge = document.getElementById('cart-count-badge');
                if (badge) badge.textContent = '0';
            })
            .catch(function() {
                showCheckoutToast('Có lỗi xảy ra, vui lòng thử lại!', true);
            })
            .finally(function() {
                btn.disabled = false;
                btn.innerHTML = 'Xác nhận đặt hàng';
            });
        });
    });
</script>
@endpush