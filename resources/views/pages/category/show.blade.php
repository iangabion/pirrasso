@extends('main.main_layout')

@section('content')
	<div class="row">
		<div class="col-md-8">
            <div class="card content_holder">
	        	<div class="card-content ">
	        		<div class="col-12 title_holder">
						<h5 class="">Categories
							<small class="text-small">Add categories</small>
						</h5>
					</div>
	        		<form class="col s12 company_form">
	        			@csrf
	     				<div class="row">
	        				<div class="input-field col-md-12 col">
		        				{{-- <i class="material-icons prefix">contact_mail</i> --}}
		        				<span class="mdi mdi-shape prefix"></span>
		          				<input id="category_name" type="text" name="category_name" class="validate category_name " required >
		          				<label for="category_name">Category Name</label>
	            				<span class="helper-text" data-error="required" data-success=""></span>
		        			</div>
	     				</div>
		    		</form>
	        	</div>
		        <div class="card-action text-right">
				    <button type="submit " class="btn waves-effect light-blue darken-3 category_submit" data_id = "" ><i class="mdi mdi-send left"></i>Submit</button>
		          	<button type="button" class="btn waves-effect reset_form_button green darken-1"><i class="mdi mdi-refresh left"></i>Reload Form</button>
		        </div>
	      	</div>
        </div>
        <div class="col-md-4">
            <div class="card content_holder">
	        	<div class="card-content ">
	        		<div class="col-12 title_holder">
						<h5 class="">Categories
							<small class="text-small">Existing categories</small>
						</h5>
                    </div>
                    <div class="card-content">
                        <table class="highlight category_table ">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Item Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category as $cat )
                                    <tr>
                                        <td>{{$cat->name}}</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">
                                            <a class='dropdown-trigger teal-text ' href='#' data-target='dropdown1'>
                                                <i class="material-icons ">more_vert</i>
                                            </a>
                                        </td>
                                        <!-- Dropdown Structure -->
                                        <ul id='dropdown1' class='dropdown-content list_action'>
                                            <li>
                                                <a href="" class="blue-text category_edit" data_id={{$cat->id}}>
                                                    <i class="mdi mdi-pencil left"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#!" class="red-text delete_category" data_id={{$cat->id}}>
                                                    <i class="mdi mdi-delete left"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-action">
		          	<span class="teal darken-3 p-2 white-text"><i class="mdi mdi-content-save"></i> {{$category->count()}} saved categories</span>
		        </div>
	      	</div>
        </div>
	</div>
@endsection