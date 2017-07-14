<div class="alert alert-info" role="alert">
    You have {{ count(session('cart')) }} {{ str_plural('item', count(session('cart'))) }} in your <a href="{{ route('cart.index') }}" class="btn btn-primary">Cart</a>
    <br>
    Proceed to <a href="{{ route('requests.create') }}" class="btn btn-success">Checkout</a>
</div>
