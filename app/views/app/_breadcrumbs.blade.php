<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
				<li><a href="/"><i class="fa fa-home"></i></a></li>
				@foreach ($crumbs as $key => $crumb)
					@if ($key)
						<li><a href="{{ $key }}">{{ $crumb }}</a></li>
					@else
						<li class="active">{{ $crumb }}</li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
</div>
