<!DOCTYPE HTML>
<html>
<head>
   <title>Operational Unit Tests</title>
   <style type="text/css">
      body {
         font-size: 0.9em;
         font-family: arial;
      }
      
      .test {  
         padding: 10px;
         margin: 10px;
         float: left;
         width: 250px;
         height: 100px;
         color: white;
         position: relative;
      }
      
      .test .name {
         font-size: 1.3em;
      }

      .test .value {
         text-align: right;
         position: absolute;
         bottom: 10px;
         right: 10px;
      }

      .test .graph {
         position: absolute;
         bottom: 0px;
         left: 0px;
      }
      
      .normal {
         background-color: #229922;
      }

      .error {
         background-color: #992222;
      }
      
   </style>
   <script type="text/javascript" src="jquery-2.1.1.min.js"></script>
   <script type="text/javascript" src="jquery.sparkline.min.js"></script>
   <script type="text/javascript" src="knockout-3.1.0.js"></script>
   <script type="text/javascript">
      
      var GRAPH_CONFIG_NORMAL = {
         width:'250px',
         height:'80px',
         lineColor: '#117711',
         fillColor: '#117711',
         spotColor: false,
         maxSpotColor: false,
         minSpotColor: false
      };
      
      var GRAPH_CONFIG_ERROR = $.extend({},GRAPH_CONFIG_NORMAL);
      GRAPH_CONFIG_ERROR['lineColor'] = '#771111';
      GRAPH_CONFIG_ERROR['fillColor'] = '#771111';
      
      
      
      function TestModel(data)
      {
         this.id = ko.observable(data.id);
         this.name = ko.observable(data.name);
         this.description = ko.observable(data.description);
         this.result = ko.observable(data.result);
         this.value = ko.observable(data.value);
         this.last_updated = ko.observable(data.last_updated);
         
         this.log = ko.observableArray();
         var self = this;
         
         $.getJSON('test_log.php?id=' + data.id,function(d){
            self.log(d);
            $('#graph' + self.id()).sparkline(d,( self.result()==1?GRAPH_CONFIG_NORMAL:GRAPH_CONFIG_ERROR));
         });
      }
      
      
      function OUTs()
      {
         var self = this;
         
         self.tests = ko.observableArray();         
         
         //populate array//
         $.getJSON('json.php',function(data){            
            $.each(data,function(i,d){
               self.tests.push(new TestModel(d));
            })                        
         });                  
      }
      
   </script>
   </head>
<body>
   
   
<div data-bind="foreach: tests">
   <div class="test" data-bind="attr: {title:description},css: (result()==1) ? 'normal' : 'error' ">
      <div class="graph" data-bind="attr: {id:'graph' + id()}"></div>
      <div class="name" data-bind="text:name"></div>
      <div class="value" data-bind="text:value"></div>
   </div>
</div>
   
   
<script type="text/javascript">
ko.applyBindings(new OUTs());
</script>   
</body>
</html>