<template>
   <div class="chartElem">
  <div class="flex">
    <div class="w-full">
      <highcharts class="chart" :options="chartOptions" :updateArgs="updateArgs"></highcharts>
    </div>
    <div class="w-full ml-4">
      <h3 class="text-lg font-bold">Flexibly change the value of each point:</h3>
      <h4 class="text-md font-bold mt-4">Possssints:</h4>
      <form class="grid grid-col-4 mt-2">
        <div v-for="index in 8" :key="index" class=" mb-2 ">
          {{ index }}:
          <input v-model.number="points[index - 1]" type="number" class="w-1/4 py-1 px-2 border border-gray-300 rounded">
        </div>
      </form>

    </div>
  </div>
  <div class="flex mt-8">
    <div id="title" class="w-full">
      <h3 class="text-lg font-bold">Set chart title dynamically:</h3>
      <input type="text" v-model="title" class="w-full py-1 px-2 mt-2 border border-gray-300 rounded">
    </div>
    <div id="chartType" class="w-1/4 ml-4">
      <h3 class="text-lg font-bold">Select chart type:</h3>
      <select v-model="chartType" class="w-full py-1 px-2 mt-2 border border-gray-300 rounded">
        <option>Spline</option>
        <option>AreaSpline</option>
        <option>Line</option>
        <option>Scatter</option>
        <option>Column</option>
        <option>Area</option>
      </select>
    </div>
    <div id="animationDuration" class="w-1/4 ml-4">
      <h3 class="text-lg font-bold">Select update animation duration:</h3>
      <select v-model.number="animationDuration" class="w-full py-1 px-2 mt-2 border border-gray-300 rounded">
        <option v-for="option in durationOptions" :value="option" :key="option">
          {{ option }}
        </option>
      </select>
    </div>
    <div id="seriesColor" class="w-1/4 ml-4">
      <h3 class="text-lg font-bold">Select color of the series:</h3>
      <div class="flex mt-2">
        <input id="colorPicker" v-if="colorInputIsSupported" type="color" v-model="seriesColor" class="w-2/3 py-1 px-2 border border-gray-300 rounded">
        <select v-else v-model="seriesColor" class="w-2/3 py-1 px-2 border border-gray-300 rounded">
          <option>Red</option>
          <option>Green</option>
          <option>Blue</option>
          <option>Pink</option>
          <option>Orange</option>
          <option>Brown</option>
          <option>Black</option>
          <option>Purple</option>
        </select>
        <p class="w-1/3 ml-2">Current color: {{ seriesColor }}</p>
      </div>
    </div>
  </div>
</div>

  </template>

  <script>
  export default {
    data () {
      return {
        title: '',
        numNum: Number,
        durationOptions: [0, 500, 1000, 2000],
        points: [10, 0, 8, 2, 6, 4, 5, 5],
        chartType: 'Spline',
        seriesColor: '#6fcd98',
        colorInputIsSupported: null,
        animationDuration: 1000,
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            type: 'spline'
          },
          title: {
            text: 'Sin chart'
          },
          series: [{
            data: [10, 0, 8, 2, 6, 4, 5, 5],
            color: '#6fcd98'
          }]
        }
      }
    },
    created () {
      let i = document.createElement('input')
      i.setAttribute('type', 'color');
      (i.type === 'color') ? this.colorInputIsSupported = true : this.colorInputIsSupported = false
    },
    watch: {
      title (newValue) {
        this.chartOptions.title.text = newValue
      },
      points: {
        handler(newValue) {
          this.chartOptions.series[0].data = newValue
        },
        deep: true
      },
      chartType (newValue) {
        this.chartOptions.chart.type = newValue.toLowerCase()
      },
      seriesColor (newValue) {
        this.chartOptions.series[0].color = newValue.toLowerCase()
      },
      animationDuration (newValue) {
        this.updateArgs[2].duration = Number(newValue)
      }
    }
  }
  </script>

  <style scoped>
  input[type="color"]::-webkit-color-swatch-wrapper {
    padding: 0;
  }
  #colorPicker {
    border: 0;
    padding: 0;
    margin: 0;
    width: 30px;
    height: 30px;
  }
  .numberInput {
    width: 30px;
  }
  </style>
