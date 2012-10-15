<div class="{{$param->search_class}}" >
<form  action="/{{URI::current()}}" >
	@if (is_array($columns))
	<span class="{{$param->span_class}}">
		<select name="s_column" >
		@foreach ($columns as $column)
   			 <option 
   			 @if (isset($s_column) && $column==$s_column) 
   			 selected="selected" 
   			 @endif 
   			 value="{{$column}}">{{__($param->bundle.'::'.$param->lang_filename.'.'.$column) }}</option>
		@endforeach
		</select>
	</span>
	<span class="{{$param->span_class}}">
		<input type="text" name="s_value" value="{{$s_value}}" />
	</span>
	@else
	<span class="{{$param->span_class}}">
		<label>{{__($param->bundle.'::'.$param->lang_filename.'.'.$columns)}}</label>
	</span>
	<span class="{{$param->span_class}}">
		<input type="hidden" name="s_column" value="{{$columns}}" /><input name="s_value" value="{{$s_value}}" />
	</span>
	@endif
	
	<span class="{{$param->span_class}}">
		<input type="submit" value="{{__('simplelist::simplelist.search')}}" />
	</span>
</form>
</div>