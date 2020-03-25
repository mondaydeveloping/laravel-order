@extends('layouts.global')
@section('title') Create book @endsection
@section('content')
    <div class="col-md-8">
      @if(session('status'))
        <div class="alert alert-success">
          {{session('status')}}
        </div>
      @endif
<form action="{{route('books.store')}}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
@csrf
 
<label for="user">Nama User</label><br>
    <select name="user[]" multiple id="user" class="form-control"></select>
<br><br>
<label for="title">Title</label><br>
    <select name="title[]" multiple id="title" class="form-control"></select>
<br><br>
<label for="quantity">quantity</label>
    <input name="quantity" class="form-control" name="quantity">
<br><br>
<label for="invoice_number">Description</label>
<br>
    <textarea name="invoice_number" id="invoice_number" class="formcontrol" placeholder="Give a about this book"></textarea>
<br>
    <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Book publisher">
<br>
<label for="Price">Price</label> 
<br>
    <input type="number" class="form-control" name="price" id="price" placeholder="Book price">
<br>
</form>

</div></div>
@endsection
@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$('#title').select2({
  ajax: {
    url: 'http://localhost:8000/ajax/books/search', processResults: function(data){
      console.log(data)
      return {
        results: data.map(function(item){return {id: item.id, text: item.title} })
      }
    }
  }
}); </script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$('#user').select2({
  ajax: {
    url: 'http://localhost:8000/ajax/users/search', processResults: function(data){
      console.log(data)
      return {
        results: data.map(function(item){return {id: item.id, text: item.name} })
      }
    }
  }
});</script>



@endsection

 

 
