<style>
    .signature-container {
        border: 1px solid #000; 
        padding: 10px;
    }
    #sign_contract {
        z-index: 9999;
    }
    #monthlyMessageContainer,
    #yearlyMessageContainer {
        opacity: 0;
        transition: opacity 0.5s ease; /* Adjust the duration and easing as needed */
    }

    #monthlyMessageContainer.visible,
    #yearlyMessageContainer.visible {
        opacity: 1;
        color: red;
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
                    <label>Type (Monthly/Yearly)</label><br>
                    <div class="p-2">
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
        const emptyDataURL = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAcIAAADICAYAAAB79OGXAAAAAXNSR0IArs4c6QAAB5FJREFUeF7t1QERAAAIAjHpX9ogPxswvGPnCBAgQIBAWGDh7KITIECAAIEzhJ6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQICAIfQDBAgQIJAWMITp+oUnQIAAAUPoBwgQIEAgLWAI0/ULT4AAAQKG0A8QIECAQFrAEKbrF54AAQIEDKEfIECAAIG0gCFM1y88AQIECBhCP0CAAAECaQFDmK5feAIECBAwhH6AAAECBNIChjBdv/AECBAgYAj9AAECBAikBQxhun7hCRAgQMAQ+gECBAgQSAsYwnT9whMgQIDAA/5PAMlUI4XMAAAAAElFTkSuQmCC';
        
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
        var monthlyRadio = document.querySelector('input[name="contract_type"][value="monthly"]');
        var yearlyRadio = document.querySelector('input[name="contract_type"][value="yearly"]');
        var monthlyContainer = monthlyRadio.closest('.form-check');
        var yearlyContainer = yearlyRadio.closest('.form-check');
        var monthlyMessageContainer = document.createElement('div');
        monthlyMessageContainer.id = 'monthlyMessageContainer';
        var yearlyMessageContainer = document.createElement('div');
        yearlyMessageContainer.id = 'yearlyMessageContainer';

        function updateMessage() {
            var monthlyMessage = '';
        var yearlyMessage = '';

        if (monthlyRadio.checked) {
            monthlyMessage = '-> Only 5 SPA available for monthly contracts.';
        } else if (yearlyRadio.checked) {
            yearlyMessage = '-> Special discount for yearly contracts and can create upto 20 SPA!';
        }

        monthlyMessageContainer.textContent = monthlyMessage;
        monthlyMessageContainer.classList.toggle('visible', monthlyRadio.checked);

        yearlyMessageContainer.textContent = yearlyMessage;
        yearlyMessageContainer.classList.toggle('visible', yearlyRadio.checked);
        }

        // Append the message containers to their respective containers
        monthlyContainer.appendChild(monthlyMessageContainer);
        yearlyContainer.appendChild(yearlyMessageContainer);

        // Add event listener to update message and visibility on radio button change
        monthlyRadio.addEventListener('change', updateMessage);
        yearlyRadio.addEventListener('change', updateMessage);

        // Set initial message and visibility
        updateMessage();
    });

    document.addEventListener('DOMContentLoaded', function () {
    var monthlyRadio = document.querySelector('input[name="contract_type"][value="monthly"]');
    var yearlyRadio = document.querySelector('input[name="contract_type"][value="yearly"]');
    var amountPaidInput = document.getElementById('amount_paid');

    function updateAmount() {
        var monthlyPrice = 100; // Replace with your actual monthly price
        var yearlyPrice = 1000; // Replace with your actual yearly price

        if (monthlyRadio.checked) {
            amountPaidInput.value = monthlyPrice;
        } else if (yearlyRadio.checked) {
            amountPaidInput.value = yearlyPrice;
        }
    }

    // Add event listener to update amount on radio button change
    monthlyRadio.addEventListener('change', updateAmount);
    yearlyRadio.addEventListener('change', updateAmount);

    // Set initial amount based on default selection
    updateAmount();
});
</script>