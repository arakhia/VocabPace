<template>
    <div class="container">
        <h1>Dashboard</h1>
        <hr>
        <br>
        <div class="row table-title">
            <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-grid" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
            </svg>
            <h3>My Vocabulary</h3>
        </div>
        
        <table class="table table-bordered">
            <tbody>
                <tr v-for="(chunk, index) in vocabularyChunk" :key="index">
                    <th v-for="(vocabulary, index2) in chunk" :key="index2">
                        <a href="" style="color: black;">{{vocabulary.value}}</a>
                    </th>
                </tr>
            </tbody>
        </table>
        <br>
        <div>
            <div id="old_games_line_chart" style="width: 900px; height: 500px;"></div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            vocabulary: null,
            vocabularyChunk: null,
            oldGames: null,
        }
    },
    created: function(){   
        this.getUserVocabulary();
    },
    methods: {
        getUserVocabulary: function()
        {
            axios.get('/api/profile/dashboard')
            .then(response => {
                this.vocabulary = response.data.vocabulary,
                this.oldGames = response.data.challenges,
                this.vocabularyChunk = _.chunk(this.vocabulary, 6),
                this.buildChallengesChart();
            });
        },
        buildChallengesChart: function()
        {
            var list = this.oldGames;

            var myData = [];
    
            for(var month in list){
                myData.push([month, list[month].length]);
            }

            var chartWidth = $(document).width() * 0.75;
            var chartHeight = chartWidth * 0.5;
            var scope = this;

            google.charts.load('current', {packages: ['corechart', 'line']});
            google.charts.setOnLoadCallback(function() {
                scope.drawLineChart(myData, 'Month', 'Challenge', 'Month', 'Challenge', 'old_games_line_chart', 'Previous Challenges', null, chartWidth, chartHeight);
            });
        },
        drawLineChart: function(myData, hAxisTitle, vAxisTitle, firstCol, secondCol, elementId, title,chartBackgroundColor, width, height)
        {
            
            var data = new google.visualization.DataTable();
            data.addColumn('string', firstCol);
            data.addColumn('number', secondCol);

            data.addRows(myData);

            if(!chartBackgroundColor){
                chartBackgroundColor = chartBackgroundColor;
            }

            var options = {
                hAxis: {
                    title: hAxisTitle
                },
                vAxis: {
                    title: vAxisTitle,
                    format: '0'
                },
                title: title, 
                width: width,
                height: height,
                backgroundColor: '#f8fafc'
            };

            var chart = new google.visualization.LineChart(document.getElementById(elementId));
            chart.draw(data, options);
        },
    }
}
</script>

<style scoped>
.table-title {
    margin: 0.5em;
}
</style>