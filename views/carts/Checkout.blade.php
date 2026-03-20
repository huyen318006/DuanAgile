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
                <div class="text-muted" style="font-size:12px;margin-top:10px;">
                    Lưu ý: Hiện chưa có API chuyển khoản QR, nên chọn mục này sẽ hiển thị trạng thái đang phát triển.
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
            toast.style.display = 'block';
            setTimeout(function() {
                toast.style.display = 'none';
            }, 4000);
        }

        btnCheckout.addEventListener('click', function() {
            var nameVal = document.getElementById('checkoutName') ? document.getElementById('checkoutName').value : '';
            var phoneVal = document.getElementById('checkoutPhone') ? document.getElementById('checkoutPhone').value : '';
            var addressVal = document.getElementById('checkoutAddress') ? document.getElementById('checkoutAddress').value : '';
            var notesVal = document.getElementById('checkoutNotes') ? document.getElementById('checkoutNotes').value.trim() : '';

            namePreview.textContent = nameVal || '-';
            phonePreview.textContent = phoneVal || '-';
            addressPreview.textContent = addressVal || '-';
            notesPreview.textContent = notesVal || 'Không có';

            checkoutModal.show();
        });

        btnConfirm.addEventListener('click', function() {
            var selectedPayment = document.querySelector('input[name="checkout_payment"]:checked');
            var paymentVal = selectedPayment ? selectedPayment.value : 'Cash';

            if (paymentVal === 'Transfer_QR') {
                showCheckoutToast('Chuyển khoản QR đang trong quá trình thêm.', true);
                return;
            }

            showCheckoutToast('Đặt hàng thành công!', false);
            checkoutModal.hide();
        });
    });
</script>
@endpush