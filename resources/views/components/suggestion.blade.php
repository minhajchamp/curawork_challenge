<div id="sugg">
  @if(isset($suggestions))
  @foreach ($suggestions as $userjob)
  <div class="my-2 shadow  text-white bg-dark p-1" id="suggestion_box_{{ $userjob->id }}">
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <div class="d-flex justify-content-between">
      <table class="ms-1">
        <td class="align-middle">{{ $userjob->name }}</td>
        <td class="align-middle"> - </td>
        <td class="align-middle">{{ $userjob->email }}</td>
        <td class="align-middle">
      </table>
      <div>
        <button id="create_request_btn" class="btn btn-primary me-1" onClick="sendRequest(<?= auth()->user()->id; ?>, <?= $userjob->id; ?>)">Connect</button>
      </div>
    </div>
  </div>
  @endforeach
  @endif
</div>