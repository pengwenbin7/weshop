<template>
  <div id="address-selector">
    <div class="form-group">
      <label for="contact_name" class="col-sm-2 control-label">联系人</label>
      <div class="col-sm-10">
	<input class="form-control" id="contact_name" name="contact_name" type="text" required>
      </div>
    </div>
    <div class="form-group">
      <label for="contact_name" class="col-sm-2 control-label">联系电话</label>
      <div class="col-sm-10">
	<input class="form-control" id="contact_tel" name="contact_tel" type="text">
      </div>
    </div>
    <div class="form-group">
      <input v-model="code" type="hidden" name="code" required>
      <label class="col-sm-2 control-label">地区</label>
      <div class="col-sm-10">
	<div class="col-sm-4">
	  <select class="form-control" name="province" v-model="province" required @change="changeProvince">
	    <option v-for="option in provinces" v-bind:value="option.id">
	      {{ option.fullname }}
	    </option>
	  </select>
	</div>
	<div class="col-sm-4">
	  <select class="form-control" name="city" v-if="cities.length" v-model="city" required @change="changeCity">
	    <option v-for="option in cities" v-bind:value="option.id">
	      {{ option.fullname }}
	    </option>
	  </select>
	</div>
	<div class="col-sm-4">
	  <select class="form-control" name="district" v-if="districts.length" v-model="district" required @change="changeDistrict">
	    <option v-for="option in districts" v-bind:value="option.id">
	      {{ option.fullname }}
	    </option>
	  </select>
	</div>
      </div>
    </div>
    <div class="form-group">
      <label for="detail" class="col-sm-2 control-label">详细地址</label>
      <div class="col-sm-10">
	<input class="form-control" id="detail" name="detail" type="text" required>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      province: null,
      provinces: [],
      city: null,
      cities: [],
      district: null,
      districts: [],
      code: null,
    };
  },
  computed: {
  },
  methods: {
    changeProvince: function () {
      var $this = this;
      axios.get("/region/children/" + this.province)
	.then(function (res) {
	  $this.cities = res.data;
	  $this.districts = [];
	  $this.city = null;
	  $this.district = null;
	  $this.code = null;
	});
    },
    changeCity: function () {
      if (!this.city) {
	return;
      }
      var $this = this;
      axios.get("/region/children/" + this.city)
	.then(function (res) {
	  $this.districts = res.data;
	  // 判断是否还有第三级
	  if (!res.data.length) {
	    $this.code = $this.city;
	  } else {
	    $this.code = null;
	  }
	  $this.district = null;
	});
    },
    changeDistrict: function () {
      this.code = this.district;
    },
  },
  mounted: function () {
    var $this = this;
    axios.get("/region/children")
      .then(function (res) {
	$this.provinces = res.data;
      });
  }
}
</script>
