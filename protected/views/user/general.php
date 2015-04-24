<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary">记账</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    今年收账：30000
                </div>
                <div class="panel-body">
                    <div id="thisyear" class="main"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    去年收账：30000
                </div>
                <div class="panel-body">
                    <div id="lastyear" class="main"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jQuery/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap/js/bootstrap.min.js"></script>
<script src="js/echarts/build/dist/echarts.js"></script>

<script>
    $(function(){
        require.config({
            paths: {
                echarts: 'js/echarts/build/dist'
            }
        });
        require(['echarts', 'echarts/chart/pie'], function(ec) {
            var chartRenders = $('.main');
            //var myChart = ec.init(document.getElementById('lastyear'));
            var option = {
                /*tooltip: {
                 trigger: 'item',
                 formatter: "{a} <br/>{b} : {c} ({d}%)"
                 },*/
                /*legend: {
                 orient: 'vertical',
                 x: 'left',
                 data: ['直接访问', '邮件营销', '联盟广告', '视频广告', '搜索引擎']
                 },*/
                /*toolbox: {
                 show: true,
                 feature: {
                 mark: {
                 show: true
                 },
                 dataView: {
                 show: true,
                 readOnly: false
                 },
                 magicType: {
                 show: true,
                 type: ['pie', 'funnel'],
                 option: {
                 funnel: {
                 x: '25%',
                 width: '50%',
                 funnelAlign: 'center',
                 max: 1548
                 }
                 }
                 },
                 restore: {
                 show: true
                 },
                 saveAsImage: {
                 show: true
                 }
                 }
                 },*/
                calculable: true,
                series: [{
                    name: '访问来源',
                    type: 'pie',
                    radius: ['50%', '70%'],
                    itemStyle: {
                        normal: {
                            label: {
                                show: false
                            },
                            labelLine: {
                                show: false
                            }
                        },
                        /*emphasis: {
                         label: {
                         show: true,
                         position: 'center',
                         textStyle: {
                         fontSize: '30',
                         fontWeight: 'bold'
                         }
                         }
                         }*/
                    },
                    data: [{
                        value: 335,
                        name: '直接访问'
                    }, {
                        value: 310,
                        name: '邮件营销'
                    }, {
                        value: 234,
                        name: '联盟广告'
                    }, {
                        value: 135,
                        name: '视频广告'
                    }, {
                        value: 1548,
                        name: '搜索引擎'
                    }]
                }]
            };
            chartRenders.each(function(i){
                ec.init($(this)[0]).setOption(option);
            });
        });
    });
</script>