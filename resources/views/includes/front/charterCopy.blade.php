<form method='post' action='{{route( 'charterCopy', [ 'charter' => $charter->id ] )}}'>
    {{ csrf_field() }}
    <input type='date' name='copyDate'/>
    <button type='submit' class='btn btn-success'>Copy Flight</button>
</form>