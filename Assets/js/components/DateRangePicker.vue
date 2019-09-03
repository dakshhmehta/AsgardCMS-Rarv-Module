<template>
  <div class="block">
    <el-date-picker
      v-if="type == 'daterange'"
      v-model="val"
      type="daterange"
      align="right"
      :name="name"
      unlink-panels
      range-separator="To"
      start-placeholder="Start date"
      end-placeholder="End date"
      :picker-options="pickerOptions2">
    </el-date-picker>
    <el-date-picker
      v-if="type == 'date'"
      :name="name"
      format="dd-MM-yyyy"
      :placeholder="placeholder"
      v-model="val"
    >
    </el-date-picker>
  </div>
</template>

<script>
  export default {
    props: ['value','name', 'type', 'placeholder'],
    mounted(){
      console.log(this.type)
      this.val = this.value
    },
    data() {
      return {
        val: null,
        pickerOptions2: {
          shortcuts: [{
            text: 'Last week',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: 'Last month',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: 'Last 3 months',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit('pick', [start, end]);
            }
          }]
        },
      };
    }
  };
</script>
<style type="text/css">
  .demonstration{
    font-weight: bold;
  }
</style>