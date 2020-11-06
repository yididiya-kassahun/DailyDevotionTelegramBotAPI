@extends('layout.layout');

@include('layout.navbar')

<div id="todo-style">
    <form action="{{ route('todo.post') }}" method="POST">
        {{ csrf_field() }}
        <input type="text" name="title" class="form-control col-md-6" placeholder="Enter Title"/><br/>
        <textarea rows="7" name="content" cols="10" placeholder="Enter ToDo List " class="form-control col-md-6">
  </textarea><br/>
        <button type="submit" class="btn btn-primary" style="margin-left: 20%">Add</button>
    </form>
    <br/>

</div>

<div class="container" id="todo-list-style">
    <hr>
    <div class="row">
        @foreach($todos as $todo)
        <div class="col-sm-6">
    <h4><b> {{ $todo->title }} </b></h4>
    <h5> {{ $todo->content }} </h5>
        <p><i>created at {{ $todo->created_at }}</i></p>
        <hr>
             </div><br/>
        <div class="col-sm-2">
            <br /><br />
            <button type="button"  class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">Update</button>
            <a class="btn btn-danger" href="{{ route('delete.todo',['id'=>$todo->id]) }}">Delete</a>
        </div>
    @endforeach
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

