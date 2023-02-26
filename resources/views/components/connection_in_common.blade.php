@if(isset($common_connection))
@foreach($common_connection as $conn)
<div class="p-2 shadow rounded mt-2  text-white bg-dark">{{ getCustomerDetail("name", $conn->id) }} - {{ getCustomerDetail("email", $conn->id) }}</div>
@endforeach
@endif