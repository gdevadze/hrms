<!DOCTYPE html>
<html>
<head>
    <title>Upload Residence Render Photo and Mark Multiple Areas</title>
    <style>
        #canvas {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<form action="#" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">Residence Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="photo">Residence Render Photo:</label>
    <input type="file" name="photo" id="photo" required>

    <input type="hidden" name="boundaries" id="boundaries">

    <button type="submit">Save</button>
</form>

<canvas id="canvas" width="800" height="600"></canvas>

<script>
    let canvas = document.getElementById('canvas');
    let ctx = canvas.getContext('2d');
    let img = new Image();
    let drawing = false;
    let polygons = [];
    let currentPolygon = [];

    document.getElementById('photo').addEventListener('change', function(e) {
        let reader = new FileReader();
        reader.onload = function(event) {
            img.onload = function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            }
            img.src = event.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    canvas.addEventListener('mousedown', function(e) {
        drawing = true;
        currentPolygon.push(getMousePos(canvas, e));
        drawPolygons();
    });

    canvas.addEventListener('mouseup', function(e) {
        drawing = false;
    });

    canvas.addEventListener('dblclick', function(e) {
        if (currentPolygon.length > 0) {
            polygons.push(currentPolygon);
            currentPolygon = [];
            drawPolygons();
        }
    });

    function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left,
            y: evt.clientY - rect.top
        };
    }

    function drawPolygons() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

        polygons.forEach(polygon => {
            drawPolygon(polygon);
        });

        if (currentPolygon.length > 0) {
            drawPolygon(currentPolygon);
        }
    }

    function drawPolygon(polygon) {
        ctx.beginPath();
        ctx.moveTo(polygon[0].x, polygon[0].y);
        for (let i = 1; i < polygon.length; i++) {
            ctx.lineTo(polygon[i].x, polygon[i].y);
        }
        ctx.closePath();
        ctx.stroke();
    }

    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('boundaries').value = JSON.stringify(polygons);
    });
</script>
</body>
</html>
