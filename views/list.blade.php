@if (isset($param->search))
{{$param->search->render($param)}}
@endif

@if (count($rows->results)==0)
<p class="simplelist_noresults">{{__('simplelist::simplelist.no_results')}}</p>
@else
{{$rows->links()}}
<table class="{{$param->table_class}}">	
<thead>
	@foreach ($param->columns as $column)
    	<th>
    		@if ($param->sort && $column->sort)
    		<a 
    		@if ($param->sorted_now==$column->orginal_name)class="simplelist_sorted" @endif 
    		href="/{{URI::current()}}?sort={{$column->orginal_name}}@if ($param->sorted_now==$column->orginal_name)&sorttype={{$param->sorted_type}}@endif{{$param->sort_append}}" >
    		@endif
    		<span>{{__($param->bundle.'::'.$param->lang_filename.'.'.$column->orginal_name)}}</span>
    		@if ($param->sort && $column->sort)
    		</a>
    		@endif
    	</th>
    	@endforeach
    	@if ($param->buttons)
    	<th>
    		<span>{{__('simplelist::simplelist.options')}}</span>
    	</th>
    	@endif
</thead>	
@foreach ($rows->results as $row)
    <tr>
    	@foreach ($param->columns as $column)
    	<td class="{{$param->td_class}}">
    		<span class="{{$param->span_class}}">{{$column->generateContent($row)}}</span>
    	</td>
    	@endforeach
    	@if ($param->buttons)
	    	<td class="{{$param->td_class}}">
	    	@foreach ($param->buttons as $button)
		    	<{{$button->element}} class="{{$button->generateClass($row)}}" 
		    	@if ($button->action) 
		    	{{$button->action_attr}}='{{$button->generateAction($row)}}' 
		    	@endif>
		    		<span class="{{$param->span_class}}">{{$button->name}}</span>
		    	</{{$button->element}}>
	    	@endforeach
    	@endif
    	</td>
    </tr>
@endforeach
</table>
{{$rows->links()}}

@endif