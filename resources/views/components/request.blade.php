@if(isset($request))
<div id="requests">
  @foreach($request as $req)
  <div class="my-2 shadow text-white bg-dark p-1" id="request_box_{{ $req->id }}">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <div class="d-flex justify-content-between">
      <table class="ms-1">
        <td class="align-middle">{{ getCustomerDetail("name", $req->send_by_id == Auth::id() ? $req->send_to_id : $req->send_by_id ?? "") }}</td>
        <td class="align-middle"> - </td>
        <td class="align-middle">{{ getCustomerDetail("email", $req->send_by_id == Auth::id() ? $req->send_to_id : $req->send_by_id ?? "") }}</td>
        <td class="align-middle">
      </table>
      <div>
        @if ($req->send_by_id == Auth::id())
        <button id="cancel_request_btn_{{ $req->sent_to_id }}" class="btn btn-danger me-1" onclick="deleteRequest(<?= auth()->user()->id; ?>, <?= $req->send_to_id; ?>,<?= $req->id; ?>)">Withdraw Request</button>
        @else
        <button id="accept_request_btn_{{ $req->sent_to_id }}" class="btn btn-primary me-1" onclick="acceptRequest(<?= auth()->user()->id; ?>,<?= $req->send_by_id; ?>,<?= $req->id; ?>)">Accept</button>
        @endif
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif