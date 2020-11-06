@extends('layout.layout')

@include('layout.navbar')
<br>

  <form action="{{ route('postItem') }}" method="POST">
     {{ csrf_field() }}
     <label>Item Name</label>
    <input type="text" name="itemName" class="form-control"><br><br>
    <label>Item price</label>
    <input type="number" name="itemPrice" class="form-control"><br>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@foreach ($store as $stores)

<h3>{{ $stores->item_name }}</h3>
<h3>{{ $stores->item_price }}</h3>

@endforeach

