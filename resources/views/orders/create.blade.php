@extends('layouts.global')
@section('title') Create book @endsection
@section('content')
<script>
	$('#myModal').on('shown.bs.modal', function() {
		$('#myInput').focus()
	})
	$('#myModal').on('hidden.bs.modal', function() {
		document.location.reload();
	})
</script>
<script language="javascript" type="text/javascript">
	function resizeIframe(obj) {
		obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	}
</script>

<div class="col-md-8">
	@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
	@endif

	<form action="{{route('orders.store')}}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
		@csrf
		<label for="user">Nomor Invoice</label><br>
		<input type="text" class="form-control" name="invoice_number" id="invoice_number" placeholder="Invoice Number">
		<br>
		<label for="user">Nama User</label><br>
		<select name="user" id="user" class="form-control"></select>
		<br><br>


		<div class="form-group">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
				Tampilkan Buku
			</button>
		</div>
		<div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<td>Nama Barang</td>
						<td>Harga</td>
					</tr>
				</thead>
				<tbody>
					@foreach($books as $p)
					<tr>
						<td>{{ $p->title }}</td>
						<td>{{ $p->price }}</td>
					</tr>

					@endforeach

				</tbody>
			</table>
		</div>
		<hr>
		{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}
		<a class="btn btn-small btn-warning" href="{{ URL::to('orders/create') }}">Batal</a>
		{!! Form::close() !!}
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="background: #fff;">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Daftar Barang</h>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<td>Nama Barang</td>
							<td>Harga</td>
							<td>Aksi</td>
						</tr>
					</thead>
					<tbody>
						@foreach($books as $p)
						<tr>
							<td>{{ $p->title }}</td>
							<td>{{ $p->price }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>

@endsection
@section('footer-scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
	$('#user').select2({
		ajax: {
			url: '{{url('ajax/users/search')}}',
			processResults: function(data) {
				console.log(data)
				return {
					results: data.map(function(item) {
						return {
							id: item.id,
							text: item.name
						}
					})
				}
			}
		}
	});
</script>
@endsection