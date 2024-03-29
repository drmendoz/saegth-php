Skip to content
Personal Open source Business Explore
Sign upSign inPricingBlogSupport
This repository
Search
 Watch 23  Star 578  Fork 102 chrisdone/jquery-console
 Code  Issues 4  Pull requests 9  Pulse  Graphs
Branch: master Find file Copy pathjquery-console/demo.html
c8812e4  Jun 5, 2014
@chr15m chr15m New method `report(msg, className)` allows external access to inject …
4 contributors @chrisdone @spratt @vietj @chr15m
RawBlameHistory     267 lines (266 sloc)  10.4 KB
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
          "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>JQuery Console Demo</title>
    <meta name="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="jquery.console.js"></script>
    <!-- Everything beyond this point is user-customized -->
    <script type="text/javascript">
      $(document).ready(function(){
         /* First console */
         var console1 = $('<div class="console1">');
         $('body').append(console1);
         var controller1 = console1.console({
           promptLabel: 'Demo> ',
           commandValidate:function(line){
             if (line == "") return false;
             else return true;
           },
           commandHandle:function(line){
               return [{msg:"=> [12,42]",
                        className:"jquery-console-message-value"},
                       {msg:":: [a]",
                        className:"jquery-console-message-type"}]
           },
           autofocus:true,
           animateScroll:true,
           promptHistory:true,
           charInsertTrigger:function(keycode,line){
              // Let you type until you press a-z
              // Never allow zero.
              return !line.match(/[a-z]+/) && keycode != '0'.charCodeAt(0);
           }
         });
         /* Second console */
         var console2 = $('<div class="console2">');
         $('body').append(console2);
         var controller2 = console2.console({
           promptLabel: 'JavaScript> ',
           commandValidate:function(line){
             if (line == "") return false;
             else return true;
           },
           commandHandle:function(line){
               try { var ret = eval(line);
                     if (typeof ret != 'undefined') return ret.toString();
                     else return true; }
               catch (e) { return e.toString(); }
           },
           animateScroll:true,
           promptHistory:true,
           welcomeMessage:'Enter some JavaScript expressions to evaluate.'
         });
         controller2.promptText('5 * 4');
         /* Third console */
         var console3CancelFlag = false;
         var console3 = $('<div class="console3">');
         $('body').append(console3);
         var controller3 = console3.console({
           promptLabel: 'Echo> ',
           commandValidate:function(line){
             if (line == "") return false;
             else return true;
           },
           commandHandle:function(line,report){
               setTimeout(function() {
		   if(!console3CancelFlag)
		       report(line);
		   else {
		       report([{msg:"User interrupt",
				className:"jquery-console-message-error"}]);
		       console3CancelFlag = false;
		   }
	       },1000);
           },
           cancelHandle:function() {
	       console3CancelFlag = true;
	   },
           animateScroll:true,
           promptHistory:true
         });
         /* Fourth console */
         var console4 = $('<div class="console4">');
         $('body').append(console4);
         var controller4 = console4.console({
           promptLabel: 'SQL> ',
           continuedPromptLabel: '  -> ',
           commandValidate:function(line){
             if (line == "") return false;
             else return true;
           },
           commandHandle:function(line,report){
              if (line.match(/;$/)) {
                 controller4.continuedPrompt = false;
                 alert("Execute: " + line);
                 return true;
              } else {
                 controller4.continuedPrompt = true;
                 return;
              }
           },
           promptHistory:true
         });
         /* Fifth console */
         var console5 = $('<div class="console1">');
         $('body').append(console5);
         var controller5  = console5.console({
          promptLabel: 'Complete> ',
          commandHandle:function(line){
            if (line) {
              return [{msg:"you typed " + line,className:"jquery-console-message-value"}];
            } else {
              var m = "type a color among (" + this.colors.join(", ") + ")";
              return [{msg:m,className:"jquery-console-message-value"}];
            }
          },
          colors: ["red","blue","green","black","yellow","white","grey"],
          cols: 40,
          completeHandle:function(prefix){
            var colors = this.colors;
            var ret = [];
            for (var i=0;i<colors.length;i++) {
              var color=colors[i];
              if (color.lastIndexOf(prefix,0) === 0) {
                ret.push(color.substring(prefix.length));
              }
            }
            return ret;
          }
         });
         /* Sixth console */
         var console6 = $('<div class="console6">');
         $('body').append(console6);
         var controller6 = console6.console({
           promptLabel: 'Periodic> ',
           commandValidate:function(line){
             if (line == "") return false;
             else return true;
           },
           commandHandle:function(line){
               return [{msg:"=> [12,42]",
                        className:"jquery-console-message-value"},
                       {msg:":: [a]",
                        className:"jquery-console-message-type"}]
           },
           autofocus:true,
           animateScroll:true,
           promptHistory:true
         });
         var counter = 0;
         setInterval(function() {
             controller6.report([{msg:"The counter is at " + (counter++) + ".",
                                  className:"jquery-console-message-value"},
                                 {msg:(counter * 3) + " seconds have elapsed.",
                                  className:"jquery-console-message-type"}]);
         }, 3000);
       });
    </script>
    <style type="text/css" media="screen">
      div.console1,div.console2,div.console3 { word-wrap: break-word; }
      /* First console */
      div.console1 { font-size: 14px }
      div.console1 div.jquery-console-inner
       { width:900px; height:200px; background:#333; padding:0.5em;
         overflow:auto }
      div.console1 div.jquery-console-prompt-box
       { color:#fff; font-family:monospace; }
      div.console1 div.jquery-console-focus span.jquery-console-cursor
       { background:#fefefe; color:#333; font-weight:bold }
      div.console1 div.jquery-console-message-error
       { color:#ef0505; font-family:sans-serif; font-weight:bold;
         padding:0.1em; }
      div.console1 div.jquery-console-message-value
       { color:#1ad027; font-family:monospace;
         padding:0.1em; }
      div.console1 div.jquery-console-message-type
       { color:#52666f; font-family:monospace;
         padding:0.1em; }
      div.console1 span.jquery-console-prompt-label { font-weight:bold }
      /* Second console */
      div.console2 { font-size: 14px; margin-top:1em }
      div.console2 div.jquery-console-inner
       { width:900px; height:200px; background:#efefef; padding:0.5em;
         overflow:auto }
      div.console2 div.jquery-console-prompt-box
       { color:#444; font-family:monospace; }
      div.console2 div.jquery-console-focus span.jquery-console-cursor
       { background:#333; color:#eee; font-weight:bold }
      div.console2 div.jquery-console-message-error
       { color:#ef0505; font-family:sans-serif; font-weight:bold;
         padding:0.1em; }
      div.console2 div.jquery-console-message-success
       { color:#187718; font-family:monospace;
         padding:0.1em; }
      div.console2 span.jquery-console-prompt-label { font-weight:bold }
      /* Third console */
      div.console3 { font-size: 14px; margin-top:1em }
      div.console3 div.jquery-console-inner
       { width:900px; height:200px; background:#efefef; padding:0.5em;
         overflow:auto }
      div.console3 div.jquery-console-prompt-box
       { color:#444; font-family:monospace; }
      div.console3 div.jquery-console-focus span.jquery-console-cursor
       { background:#333; color:#eee; font-weight:bold }
      div.console3 div.jquery-console-message-error
       { color:#ef0505; font-family:sans-serif; font-weight:bold;
         padding:0.1em; }
      div.console3 div.jquery-console-message-success
       { color:#187718; font-family:monospace;
         padding:0.1em; }
      div.console3 span.jquery-console-prompt-label {
      font-weight:bold }
      /* Fourth console */
      div.console4 { font-size: 14px; margin-top:1em }
      div.console4 div.jquery-console-inner
       { width:900px; height:200px; background:#efefef; padding:0.5em;
         overflow:auto }
      div.console4 div.jquery-console-prompt-box
       { color:#444; font-family:monospace; }
      div.console4 div.jquery-console-focus span.jquery-console-cursor
       { background:#444; color:#eee; font-weight:bold }
      div.console4 div.jquery-console-message-error
       { color:#ef0505; font-family:sans-serif; font-weight:bold;
         padding:0.1em; }
      div.console4 div.jquery-console-message-success
       { color:#187718; font-family:monospace;
         padding:0.1em; }
      div.console4 span.jquery-console-prompt-label { font-weight:bold }
      /* Sixth console */
      div.console6 { font-size: 14px }
      div.console6 div.jquery-console-inner
       { width:900px; height:200px; background:#333; padding:0.5em;
         overflow:auto }
      div.console6 div.jquery-console-prompt-box
       { color:#fff; font-family:monospace; }
      div.console6 div.jquery-console-focus span.jquery-console-cursor
       { background:#fefefe; color:#333; font-weight:bold }
      div.console6 div.jquery-console-message-error
       { color:#ef0505; font-family:sans-serif; font-weight:bold;
         padding:0.1em; }
      div.console6 div.jquery-console-message-value
       { color:#1ad027; font-family:monospace;
         padding:0.1em; }
      div.console6 div.jquery-console-message-type
       { color:#52666f; font-family:monospace;
         padding:0.1em; }
      div.console6 span.jquery-console-prompt-label { font-weight:bold }
    </style>
  </head>
  <body>
    <noscript>
      <p>
        <strong>Please enable JavaScript or upgrade your browser.</strong>
      </p>
    </noscript>
    <h1>Simple console demo</h1>
    <p>Tested on:</p>
    <ul>
      <li>Internet Explorer 6</li>
      <li>Opera 10.01</li>
      <li>Chromium 4.0.237.0 (Ubuntu build 31094)</li>
      <li>Firefox 3.5.8</li>
    </ul>
  </body>
</html>
Status API Training Shop Blog About
© 2016 GitHub, Inc. Terms Privacy Security Contact Help