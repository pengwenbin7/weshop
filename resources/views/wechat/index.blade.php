@extends("layouts.wechat")

@section("content")
  <button id="share">分享到朋友圈</button>
@endsection

@section("script")
  <script>
  $(document).ready(function () {
    $("#share").click(function () {
      wx.onMenuShareTimeline({
	title: "分享标题",
	link: "{{ route("wechat.index") }}",
	imgUrl: "",
	success: function () {
	  alert("Nice, share + 1!");
	},
	cancel: function () {
	  alert("Wooooole, cancel sharing!");
	}
      });
    });
  });
  </script>
@endsection
