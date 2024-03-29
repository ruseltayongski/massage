<style>
    .signature-container {
        border: 1px solid #000; 
        padding: 10px;
    }
    #sign_contract {
        z-index: 9999;
    }
    #weeklyMessageContainer, #monthlyMessageContainer,
    #yearlyMessageContainer {
        opacity: 0;
        transition: opacity 0.5s ease; /* Adjust the duration and easing as needed */
    }

    #weeklyMessageContainer.visible, #monthlyMessageContainer.visible,
    #yearlyMessageContainer.visible {
        opacity: 1;
        color: red;
    }
    .make-booking {
        display: flex !important;
        justify-content: center !important;
        align-items: center;
    }
    h1 {
        text-align: center;
        margin: 20px 0;
        color: black;
    }

    textarea {
        width: 100%;
        height: 150px;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
    }

    .policy {
        color: black;
    }
</style>
{{-- <div class="modal fade mt-3" id="sign_contract" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Create Contract</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="contractForm" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Type (Monthly/Yearly)</label><br>
                        <div class="p-2">
                            <div class="form-check form-check-primary">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="contract_type" id="contract_type" checked>
                                    Monthly
                                </label>
                            </div>
                            <div class="form-check form-check-primary">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="contract_type" id="contract_type">
                                    Yearly
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount_paid">Amount Paid</label>
                        <input type="number" step="0.01" class="form-control" id="amount_paid" name="amount_paid" required>
                    </div>
                    <div class="form-group">
                        <label for="amount_picture">Amount Picture</label>
                        <input type="file" class="form-control-file" id="amount_picture" name="amount_picture">
                    </div>
                    <div class="form-group">
                        <div class="signature-container">
                            <canvas id="signatureCanvas" width="450" height="200"></canvas>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-5" id="clearSignature">Clear Signature</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Contract</button>
                </div>
            </form>
        </div>
    </div>
</div>  --}}

<div class="modal fade" id="sign_contract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Manage Contract</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
    </div>
    <form id="contractForm" method="POST">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label>Type (Weekly/Monthly/Yearly)</label><br>
                    <div class="p-2">
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="contract_type" value="weekly">
                                Weekly
                            </label>
                        </div>
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="contract_type" value="monthly">
                                Monthly
                            </label>
                        </div>
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="contract_type" value="yearly">
                                Yearly
                            </label>
                        </div>
                    </div>
                </div>
            
                <div class="form-group amount-paid">
                    <label for="amount_paid">Amount Paid</label>
                    <input type="number" step="0.01" class="form-control" id="amount_paid" name="amount_paid" required>
                </div>
                <div class="form-group">
                    <label for="amount_picture">Amount Picture</label>
                    <input type="file" class="form-control-file" id="amount_picture" name="amount_picture">
                </div>
                <div class="form-group">
                    <div class="signature-container">
                        <canvas id="signatureCanvas" width="450" height="200"></canvas>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary mt-5" id="clearSignature">Clear Signature</button>
                </div>
                <h1 class="text-center">Terms of Booking</h1>                 
                <div class="form-group">
                    <textarea class="w-100" cols="30" rows="10" readonly>
                        By agreeing to our Terms, you’re agreeing to everything in all inputted details. If you don’t accept any of these Terms, please do not use our Platform.
                        All this information is important because it (along with your booking confirmation and any pre-contractual information provided before you book) sets out the legal terms on which Service Providers offer their Travel Experiences through our Platform.
                    </textarea>
                </div>
                <div class="">
                    <input type="checkbox" class="{{-- form-check-input --}}" id="trigger_booking" name="trigger_booking">
                    <label class="form-check-label policy" for="trigger_booking">I have read and accept the terms of contract</label>
                </div>
            </div>
            <div class="modal-footer enable_contract">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" disabled>Create Contract</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    const canvas = document.getElementById('signatureCanvas');
    const context = canvas.getContext('2d');
    const clearButton = document.getElementById('clearSignature');
    const saveButton = document.getElementById('saveSignature');
    const lineWidth = 3;
    let isDrawing = false;

    context.lineWidth = lineWidth;

    canvas.addEventListener('mousedown', () => {
        isDrawing = true;
        context.beginPath();
        context.moveTo(event.clientX - canvas.getBoundingClientRect().left, event.clientY - canvas.getBoundingClientRect().top);
    });

    canvas.addEventListener('mousemove', () => {
        if (isDrawing) {
            context.lineTo(event.clientX - canvas.getBoundingClientRect().left, event.clientY - canvas.getBoundingClientRect().top);
            context.stroke();
        }
    });

    canvas.addEventListener('mouseup', () => {
        isDrawing = false;
    });

    clearButton.addEventListener('click', () => {
        context.clearRect(0, 0, canvas.width, canvas.height);
    });


    function saveContract() {
        const contractType = $("input[name='contract_type']:checked").val();
        const amountPaid = $("#amount_paid").val();
        const signatureImage = canvas.toDataURL();
        const amountPicture = $('#amount_picture')[0].files[0];
        const emptyDataURL = 'data:image/png;base64,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';
        
        if (!amountPicture) {
            alert('Please upload an amount picture.');
            return false;
        }

        if (signatureImage == emptyDataURL) {
            alert('Please provide a signature.');
            return false; 
        }

        const url = "{{ route('owner.contract.save') }}";
        var formData = new FormData();
        formData.append('contract_type', contractType);
        formData.append('amount_paid', amountPaid);
        formData.append('amount_picture', amountPicture);
        formData.append('signature', signatureImage);

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (result) {
                if(result) {
                    window.location.href="{{ route('owner/dashboard') }}";
                    //location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        return true;
    }

    document.getElementById('contractForm').addEventListener('submit', function(event) {
        event.preventDefault();
        saveContract();
    });

    
    document.addEventListener('DOMContentLoaded', function () {
        var weeklyRadio = document.querySelector('input[name="contract_type"][value="weekly"]');
        var monthlyRadio = document.querySelector('input[name="contract_type"][value="monthly"]');
        var yearlyRadio = document.querySelector('input[name="contract_type"][value="yearly"]');
        
        var weeklyContainer = weeklyRadio.closest('.form-check');
        var monthlyContainer = monthlyRadio.closest('.form-check');
        var yearlyContainer = yearlyRadio.closest('.form-check');
        
        var weeklyMessageContainer = document.createElement('div');
        weeklyMessageContainer.id = 'weeklyMessageContainer';
        var monthlyMessageContainer = document.createElement('div');
        monthlyMessageContainer.id = 'monthlyMessageContainer';
        var yearlyMessageContainer = document.createElement('div');
        yearlyMessageContainer.id = 'yearlyMessageContainer';
       
        function updateMessage() {
            var weeklyMessage = '';
            var monthlyMessage = '';
            var yearlyMessage = '';

            if (weeklyRadio.checked) {
                weeklyMessage = '-> Only 1 SPA available for weekly contracts.';
            } 
            else if (monthlyRadio.checked) {
                monthlyMessage = '-> Only 5 SPA available for monthly contracts.';
            } 
            else if (yearlyRadio.checked) {
                yearlyMessage = '-> Special discount for yearly contracts and can create upto 20 SPA!';
            }

            weeklyMessageContainer.textContent = weeklyMessage;
            weeklyMessageContainer.classList.toggle('visible', weeklyRadio.checked);

            monthlyMessageContainer.textContent = monthlyMessage;
            monthlyMessageContainer.classList.toggle('visible', monthlyRadio.checked);

            yearlyMessageContainer.textContent = yearlyMessage;
            yearlyMessageContainer.classList.toggle('visible', yearlyRadio.checked);
        }

        weeklyContainer.appendChild(weeklyMessageContainer);
        monthlyContainer.appendChild(monthlyMessageContainer);
        yearlyContainer.appendChild(yearlyMessageContainer);

        weeklyRadio.addEventListener('change', updateMessage);
        monthlyRadio.addEventListener('change', updateMessage);
        yearlyRadio.addEventListener('change', updateMessage);

        updateMessage();
    });

    document.addEventListener('DOMContentLoaded', function() {
    var triggerBooking = document.getElementById('trigger_booking');

    if (triggerBooking) {
            triggerBooking.addEventListener('change', function() {
                var isChecked = document.querySelector('input[name="trigger_booking"]:checked');

                if (isChecked) {
                    console.log("rodfil");
                    var buttons = document.querySelectorAll('.enable_contract button');
                    buttons.forEach(function(button) {
                        button.disabled = false;
                    });
                } else {
                    var buttons = document.querySelectorAll('.enable_contract button');
                    buttons.forEach(function(button) {
                        button.disabled = true;
                    });
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        var weeklyRadio = document.querySelector('input[name="contract_type"][value="weekly"]');
        var monthlyRadio = document.querySelector('input[name="contract_type"][value="monthly"]');
        var yearlyRadio = document.querySelector('input[name="contract_type"][value="yearly"]');
        var amountPaidInput = document.getElementById('amount_paid');
        var amountPaidContainer = document.querySelector('.amount-paid'); 
        var gcashContainer = yearlyRadio.closest('.amount-paid');
        var gcashMessageContainer = document.createElement('div');
        gcashMessageContainer.id = 'gcashMessageContainer';

        function updateAmount() {
            var weeklyPrice = 100; 
            var monthlyPrice = 1000; 
            var yearlyPrice = 2500;
            var gcashMessage = "";

            if (weeklyRadio.checked) {
                amountPaidInput.value = weeklyPrice;
                gcashMessage = "For Gcash Payment, kindly send to this number 09457163995.";
            } else if (monthlyRadio.checked) {
                amountPaidInput.value = monthlyPrice;
                gcashMessage = "For Gcash Payment, kindly send to this number 09457163995.";
            } else if (yearlyRadio.checked) {
                amountPaidInput.value = yearlyPrice;
                gcashMessage = "For Gcash Payment, kindly send to this number 09457163995.";
            }

            gcashMessageContainer.textContent = gcashMessage;
            gcashMessageContainer.style.marginTop = '10px';
        }

        amountPaidContainer.appendChild(gcashMessageContainer);
        weeklyRadio.addEventListener('change', updateAmount);
        monthlyRadio.addEventListener('change', updateAmount);
        yearlyRadio.addEventListener('change', updateAmount);

        updateAmount();
    });
</script>