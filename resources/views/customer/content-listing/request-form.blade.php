@include('inc.errors')

<form action="{{ route('customer.content.request.request') }}" method="POST">
    @csrf

    <input type="text" name="title" placeholder="title">

    <input type="text" name="description" placeholder="description">

    <input type="number" name="word_count">

    <input type="date" name="deadline">

    <!-- <input type="text" name="options[]">

    <input type="text" name="options[]">

    <input type="text" name="options[]"> -->

    <button>Submit</button>

</form>