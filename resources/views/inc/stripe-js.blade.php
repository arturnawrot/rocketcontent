<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('pk_test_51K6PGJGAA2s7aUvAg2WBlwfxk4MSo9bWpJxTmkbnJDD7N5jTyGXQW6rEncqTvaog2Sz5MtCQiJdlnphoDyOLVraD00PzPtG1Vt');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('loginButton');
    const clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', async (e) => {
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardHolderName.value }
            }
        }
    );

    if (error) {
        console.log('error');
        
    } else {
        document.getElementById('payment-method').value = setupIntent.payment_method;

        document.getElementById('registration-form').submit();
    }
});
</script>