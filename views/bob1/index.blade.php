@extends('lasallecmsadmin::bob1.layouts.default')

@section('content')

    <!-- Main content -->
    <section class="content">

        <div class="container">

            {{-- form's title --}}
            <div class="row">
                <br /><br />
                {!! $HTMLHelper::adminPageTitle('LaSalleCMS', 'Knowledge Base Items', '') !!}
                <br /><br />
            </div> <!-- row -->


		<div class="row">
			<div class="col-md-1"></div>
				<div class="col-md-10">

			@if (count($records) > 0 )
				{{-- http://laravel-recipes.com/recipes/256/assigning-a-variable-in-a-blade-template --}}
				{{--*/ $catId = 0 /*--}}
				<select id="foo" class="btn btn-info" style="font-size:120%;font-weight: 500;">
				<option>Go To Category (this page only)</option>
				@foreach ($records as $record)
					@if ($record->kb_category_id != $catId)
					    {{--*/ $catId = $record->kb_category_id /*--}}
					    <option style="border-bottom: grey solid 1px;" value="{!! $fullURL !!}#{!! $HTMLHelper::getTitleById('kb_lookup_categories', $record->kb_category_id) !!}">{!! $HTMLHelper::getTitleById('kb_lookup_categories', $record->kb_category_id) !!}</option>
					@endif
				@endforeach
				</select>​

			<script>
			    document.getElementById("foo").onchange = function() {
				if (this.selectedIndex!==0) {
				    window.location.href = this.value;
				}        
			    };
			</script>
			@endif

				</div> <!-- col-md-10 -->
			<div class="col-md-1"></div>
		</div> <!-- row -->




            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')

                <div class="col-md-1"></div>

                <div class="col-md-10">

                    @if (count($records) > 0 )

                        {!! $HTMLHelper::adminCreateButton('kbitems', 'kb_item', 'right') !!}

                        {!! $records->render() !!}

                        {{-- http://laravel-recipes.com/recipes/256/assigning-a-variable-in-a-blade-template --}}
                        {{--*/ $catId = 0 /*--}}

                        @foreach ($records as $record)

                            @if ($record->kb_category_id != $catId)
                                {{--*/ $catId = $record->kb_category_id /*--}}
                                <br />
                                <h1 id="{!! $HTMLHelper::getTitleById('kb_lookup_categories', $record->kb_category_id) !!}"><span class="label label-warning">
                                   {!! $HTMLHelper::getTitleById('kb_lookup_categories', $record->kb_category_id) !!}
                                </span></h1>

                            @endif


                            <br />

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    @if ($record->link != "")
                                        <h4><a href="{{{ $record->link }}}" target="_blank">{{{ $record->title }}}</a></h4>
                                    @else
                                        <h4>{{{ $record->title }}}</h4>
                                    @endif

                                    {{{ $record->description }}}

                                    <br />

                                    <table>
                                        <tr>
                                            <td>
                                                {{-- SHOW BUTTON --}}
                                                <a href="{{{ URL::route('admin.kbitems.show', $record->id) }}}" class="btn btn-success  btn-xs" role="button">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>

                                            <td>&nbsp;</td>

                                            <td>
                                                {{-- EDIT BUTTON --}}
                                                <a href="{{{ URL::route('admin.kbitems.edit', $record->id) }}}" class="btn btn-success  btn-xs" role="button">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </td>

                                            <td>&nbsp;</td>

                                            <td>
                                                {{-- DELETE BUTTON --}}
                                                <form method="POST" action="{{{ Config::get('app.url') }}}/index.php/admin/kbitems/confirmDeletion/{{ $record->id }}" accept-charset="UTF-8">
                                                {{{ csrf_field() }}}

                                                <button type="submit" class="btn btn-danger btn-xs">
                                                <i class="fa fa-times"></i>
                                                </button>

                                                </form>

                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        @endforeach

                        {!! $records->render() !!}

                        {!! $HTMLHelper::adminCreateButton('kbitems', 'kb_item', 'right') !!}

                    @else
                        <br /><br />
                        <h2>
                            There are no Knowledge Base items. Go ahead, create your first Knowledge Base item!
                        </h2>

                        <br />

                        {!! $HTMLHelper::adminCreateButton('kbitems', 'kb_item', 'left') !!}

                    @endif

                </div> <!-- col-md-10 -->

                <div class="col-md-1"></div>

            </div> <!-- row -->

        </div> <!-- container -->

    </section>

@stop