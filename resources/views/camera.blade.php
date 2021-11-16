<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Convert Image to Grayscale</h1>
        <canvas id="image_display"></canvas>
        <p>
        <input type="file" id="image_file" accept="image/*" capture="camera" onchange="upload()">
        </p>
        <p>
        <input type="button" value="Run OCR" onclick="makeGray()">
        </p>
        <br>
        Progress: <p id="progress">0%</p>
        Result: <p id="result"></p>
        <script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>
        <script src='https://unpkg.com/tesseract.js@v2.0.0-alpha.13/dist/tesseract.min.js'></script>
        <script>
        const { TesseractWorker } = Tesseract;
        const worker = new TesseractWorker();
       
        var image = null;

        function upload() {
            //Get input from file input
            var fileinput = document.getElementById("image_file");
            console.log(fileinput);
            //Make new SimpleImage from file input
            image = new SimpleImage(fileinput);
            //Get canvas
            var canvas = document.getElementById("image_display");
            //Draw image on canvas
            image.drawTo(canvas);
            //canvas.style.visibility='hidden';
        }

        function makeGray() {
            //change all pixels of image to gray
            for (var pixel of image.values()) {
                var avg = (pixel.getRed()+pixel.getGreen()+pixel.getBlue())/3;
                pixel.setRed(avg);
                pixel.setGreen(avg);
                pixel.setBlue(avg);
            }
            //image.setSize(100,100);
            //display new image
            var canvas = document.getElementById("image_display");
            image.drawTo(canvas);
            console.log(image);
            worker
            .recognize(canvas, 'eng')
            .progress((p) => {
                console.log('progress', p);
                if (p['status'] == "recognizing text")
                    document.getElementById('progress').innerHTML = p['progress'] * 100 + "%";
                else
                    document.getElementById('progress').innerHTML = "Initializing...";
            })
            .then(({ text }) => {
                console.log(text);
                document.getElementById('result').innerHTML = text;
                worker.terminate();
            });
        }
        </script>
        <!-- source: http://www.w3.org/TR/html-media-capture/ -->
    </body>
</html>
