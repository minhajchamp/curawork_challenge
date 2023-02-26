@if(isset($connection))
@foreach($connection as $conn)
<div class="my-2 shadow text-white bg-dark p-1" id="connection_box_{{ $conn->id }}">
  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{ $conn->id }} {{ getCustomerDetail("name", $conn->id) ?? "" }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ getCustomerDetail("email", $conn->id) ?? "" }}</td>
      <td class="align-middle">
    </table>
    <div>
      <button style="width: 220px" id="get_connections_in_common_{{ $conn->id }}" class="btn btn-primary" <?= getCommonConnections($conn->id) == 0 ? 'disabled ' : ''; ?>onClick="getConnectionsInCommon(<?= auth()->user()->id; ?>,<?= $conn->id; ?>)" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $conn->id }}">
        Connections in common ( {{ getCommonConnections($conn->id) }} )
      </button>
      <button id="create_request_btn_{{ $conn->id }}" class="btn btn-danger me-1" onClick="removeConnection(<?= auth()->user()->id; ?>, <?= $conn->id; ?>)">Remove Connection</button>
    </div>

  </div>
  <div class="collapse" id="collapse_{{ $conn->id }}">
    <div id="content_{{ $conn->id }}" class="p-2">
      <div id="sub_content"></div>
    </div>
    <div id="connections_in_common_skeletons_{{ $conn->id }}">
      <div class="px-2">
        @for ($i = 0; $i
        < 10; $i++) <x-skeleton />
        @endfor
      </div>
    </div>
    <div class="d-flex justify-content-center w-100 py-2">
      <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_{{ $conn->id }}" onclick="loadMoreToggle(<?= $conn->id; ?>)" id="load_more_btn">Load
        more</button>
    </div>
  </div>
</div>
@endforeach
@endif