<template>
  <div class="row">
    <div class="col-12 text-center">
      <h1> BreakDown </h1>
    </div>
    <div class="divTable" align="center">
      <div class="headerRow">
        <div class="divCell"><b>Match(%)</b></div>
        <div class="divCell"><b>Attribute</b></div>
        <div class="divCell"><b>Occupation 1</b></div>
        <div class="divCell"><b>Occupation 2</b></div>
      </div>

      <div v-for="(breakdownItem,index) in breakdown" class="divRow">
        <div class="divCell">{{ breakdownItem.match }}</div>
        <div class="divCell">{{ breakdownItem.attribute }}</div>
        <div class="divCell">{{ breakdownItem.occupation_1 }}</div>
        <div class="divCell">{{ breakdownItem.occupation_2 }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'breakdown-component',
  props: {
    breakdown: {
      default: ''
    }
  }

}
</script>

<style lang="scss" scoped>

.divTable {
  display: table;
  width: auto;
  background-color: #eee;
  border: 1px solid #666666;
  border-spacing: 5px;
}

.divRow {
  width: auto;
  display: table-row;
}

.divCell {
  width: 200px;
  float: left;
  display: table-column;
  background-color: rgb(212, 209, 209);
}
</style>