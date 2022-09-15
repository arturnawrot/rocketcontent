<script src="https://js.stripe.com/v3/"></script>

<script>
    const loadingAnimationCss = {
        "filter": "blur(7px)",
        "cursor": "not-allowed",
        "pointer-events": "none",
        "user-select": "none"
    };

    function displayCircle()
    {
        var circle = $(`
            <div class="loader">
                <div class="circle one"></div>
                <div class="circle two"></div>
                <div class="circle three"></div>
            </div>
        `);

        $('body').append(circle);
    }

    function displayError(message)
    {
        var errorMessageHtml = $(
            `<div class="alert alert-danger alert-dismissable fade show" role="alert">
                <li>
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="d-inline">${message}</div>
                </li>
            </div>`
        );

        $("#js-errors").append(errorMessageHtml);
    }

    function turnOnLoadingAnimation()
    {
        $("#main").css(loadingAnimationCss);
        displayCircle();
    }

    function turnOffLoadingAnimation()
    {
        var attributesToBeRemoved = Object.keys(loadingAnimationCss);

        attributesToBeRemoved.forEach(attribute => {
            $('#main').css(attribute, "");
        });

        $('.loader').remove();
    }

    function clearErrors()
    {
        $('.alert').remove();
    }

    async function submitData(clientSecret)
    {
        console.log(clientSecret);

        const cardHolderName = document.getElementById('card-holder-name');

        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: { name: cardHolderName.value }
                }
            }
        );

        if (error) {
            displayError(error.message);
            turnOffLoadingAnimation();
        } else {
            document.getElementById('payment-method').value = setupIntent.payment_method;

            await document.getElementById('registration-form').submit();
        }

    }

    var clientSecret;

    const stripe = Stripe("{{ env('STRIPE_KEY') }}");

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardButton = document.getElementById('loginButton');

cardButton.addEventListener('click', async (e) => {
    $( document ).ready(async function() {
        clearErrors();

        turnOnLoadingAnimation();

        await $.ajax({
            url: "{{ route('api.customer.intentToken.get') }}",
            type: 'GET',
            success: function(res) {
                $('#loginButton').attr('data-secret', res);
                submitData(res);
            }
        });

    });
});
</script>