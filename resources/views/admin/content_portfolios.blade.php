<div style="margin: 0px 50px;">
	@if($portfolios)
		<table class="table table-hover table-striped">
			<thead>
				<th>№ п/п</th>
				<th>Имя</th>
				<th>Фотография</th>
				<th>Фильтр</th>
				<th>Дата создания</th>
				<th>Дата обновления</th>
				<th>Удалить</th>
			</thead>
			<tbody>
				@foreach($portfolios as $k=>$portfolio)
					<tr>
						<td>{{ $portfolio-> id }}</td>
						<td>{!! Html::link(route('portfoliosEdit',['portfolio'=>$portfolio->id]),$portfolio->name,['alt'=>$portfolio->name]) !!}</td>
						<td>{{ $portfolio-> images }}</td>
						<td>{{ $portfolio-> filter }}</td>
						<td>{{ $portfolio-> created_at }}</td>
						<td>{{ $portfolio-> updated_at }}</td>

						<td>
							{!! Form ::open(['url'=>route('portfoliosEdit',['portfolio'=>$portfolio->id]), 'class'=>'form-horizontal','method'=>'POST']) !!}

								{{ method_field('DELETE') }}
								{!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
							{!! Form ::close() !!}
						</td>	
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif

{!! Html::link(route('portfoliosAdd'),'Новое портфолио','class="btn btn-default"') !!}

</div>