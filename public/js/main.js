var skeletonId = "skeleton";
var contentId = "content";
var skipCounter = 0;
var takeAmount = 10;
var pageNo = 1;

// Delete Specific Row
function deleteDiv(type, id) {
  var div_id = `div#${type}_box_` + id;
  console.log(div_id);
  $(div_id).remove();
}

// Refresh Data by clearing divs and loaders
function refreshData() {
  $("#content").empty();
  $("#load_more_btn_parent").removeClass("d-none");
  pageNo = 1;
}

// Refresh Data by clearing divs and loaders for Toggle (Common Connections)
function refreshDataToggle(id) {
  // $("#content_" + id).empty();
  // $("#load_more_btn_parent").removeClass("d-none");
  pageNo = 1;
}

// Generic Load more function
function loadMore() {
  const typeCondition = $("#load_more_btn").attr("data-type");
  const mode = $(this).data("mode");
  switch (typeCondition) {
    case "suggestions":
      pageNo = pageNo + 1;
      getMoreSuggestions(pageNo);
      break;
    case "requests":
      pageNo = pageNo + 1;
      getMoreRequests(mode, pageNo);
      break;
    case "connections":
      pageNo = pageNo + 1;
      getMoreConnections(pageNo);
      break;
  }
}

// Load More for Common Connection
function loadMoreToggle(id) {
  pageNo = pageNo + 1;
  getMoreConnectionsInCommon("", id, pageNo);
}

function ajaxCall(type, page_no = null, mode) {
  $.ajax({
    url: page_no
      ? `${type}?page=${page_no}&mode=${mode}`
      : `${type}?mode=${mode}`,
    type: "GET",
    beforeSend: function() {
      $("#connections_in_common_skeleton").removeClass("d-none");
    }
  })
    .done(function(data) {
      $("#connections_in_common_skeleton").addClass("d-none");
      $("#content").append(data.html);
      if (!(data.count < 10)) {
        $("#load_more_btn").attr("data-type", type);
      }
      if (data.count < 10) {
        $("#load_more_btn_parent").addClass("d-none");
      }
    })
    .fail(function(jqXHR, ajaxOptions, thrownError) {
      alert("No response from server");
    });
}

function ajaxCallToggle(type, page_no = null, id) {
  $.ajax({
    url: page_no ? `${type}?page=${page_no}` : `${type}`,
    type: "GET",
    beforeSend: function() {
      $("#connections_in_common_skeletons_" + id).removeClass("d-none");
    }
  })
    .done(function(data) {
      $("#connections_in_common_skeletons_" + id).addClass("d-none");
      $("#get_connections_in_common_" + id).attr("aria-expanded", "true");
      page_no != null
        ? $("#content_" + id).append(data.html)
        : $("#content_" + id).html(data.html);
      console.log("sttt", data.count);
      if (data.count < 1) {
        $("#load_more_connections_in_common_" + id).addClass("d-none");
      }
    })
    .fail(function(jqXHR, ajaxOptions, thrownError) {
      alert("No response from server");
    });
}

function getRequests(mode) {
  refreshData();
  mode == "accept"
    ? ajaxCall("requests", null, mode)
    : ajaxCall("requests", null, mode);
}

function getMoreRequests(mode, page_no) {
  ajaxCall("requests", page_no);
}

function getConnections() {
  refreshData();
  ajaxCall("connections");
}

function getMoreConnections(page_no) {
  ajaxCall("connections", page_no);
}

function getConnectionsInCommon(userId, connectionId) {
  refreshDataToggle(connectionId);
  ajaxCallToggle("connections/show/" + connectionId, null, connectionId);
}

function getMoreConnectionsInCommon(userId, connectionId, page_no) {
  ajaxCallToggle("connections/show/" + connectionId, page_no, connectionId);
}

function getSuggestions() {
  refreshData();
  ajaxCall("suggestions");
}

function getMoreSuggestions(page_no) {
  ajaxCall("suggestions", page_no);
}

function sendRequest(userId, suggestionId) {
  $.ajax({
    url: `suggestions/send_request`,
    type: "POST",
    data: { _token: $("#token").val(), user_id: userId, sugg_id: suggestionId },
    datatype: "JSON",
    success: function(result) {
      deleteDiv("suggestion", suggestionId);
    }
  });
}

function deleteRequest(userId, requestId, divId) {
  $.ajax({
    url: `requests/destroy/${requestId}`,
    type: "DELETE",
    data: { _token: $("#token").val(), userId: userId, requestId: requestId },
    datatype: "JSON",
    success: function(result) {
      deleteDiv("request", divId);
    }
  });
}

function acceptRequest(userId, connectedById, divId) {
  $.ajax({
    url: `requests/store`,
    type: "POST",
    data: {
      _token: $("#token").val(),
      userId: userId,
      connected_by_id: connectedById
    },
    datatype: "JSON",
    success: function(result) {
      deleteDiv("request", divId);
    }
  });
}

function removeConnection(userId, connectionId) {
  $.ajax({
    url: `connections/destroy/${connectionId}`,
    type: "DELETE",
    data: { _token: $("#token").val()},
    datatype: "JSON",
    success: function(result) {
      deleteDiv("connection", connectionId);
    }
  });
}

$(function() {
  getSuggestions();
  $("#get_suggestions_btn").click(function() {
    getSuggestions();
  });
  $("#get_sent_requests_btn").click(function() {
    getRequests("sent");
  });
  $("#get_received_requests_btn").click(function() {
    getRequests("accept");
  });
  $("#get_connections_btn").click(function() {
    getConnections();
  });
});
