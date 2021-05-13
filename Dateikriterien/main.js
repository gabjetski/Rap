document.getElementById("fileinput").addEventListener('change', function(){
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = function (event) {
        var audioContext = new (window.AudioContext || window.webkitAudioContext)();

        audioContext.decodeAudioData(event.target.result, function(buffer) {
            var duration = buffer.duration;

            if(duration > 60){
              // Umredchnen in Minuten und genaue Sekunden
            } else {
            console.log("Duration: : " + duration + " seconds");
          }
        });
    };
    reader.onerror = function (event) {
        console.error("Error: ", event);
    };
    reader.readAsArrayBuffer(file);
}, false);
