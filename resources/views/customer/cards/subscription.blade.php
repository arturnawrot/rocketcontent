<div class="card">
    <div class="card-body">
        <h2 id="card-title">Subscription</h2>
        This is some text within a card body.
        {{ auth()->user()->present()->formattedNextBillingDate() }}
    </div>
</div>