<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiblat Direction</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 0;
        background-color: #f3f3f3;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    h1 {
        margin-bottom: 20px;
    }

    .compass {
        width: 300px;
        height: 300px;
        position: relative;
    }

    .compass img {
        width: 100%;
        height: auto;
    }

    .needle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform-origin: 50% 100%;
        transform: translate(-50%, -100%) rotate(0deg);
        transition: transform 0.5s ease-in-out;
    }

    .direction {
        margin-top: 20px;
        font-size: 24px;
        font-weight: bold;
    }

    .coordinates {
        margin-top: 10px;
        font-size: 18px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Kiblat Direction</h1>
        <div class="compass">
            <img src="compass.png" alt="Compass">
            <div class="needle"></div>
        </div>
        <div class="direction">
            Arah Kiblat: <span id="direction">Loading...</span>°
        </div>
        <div class="coordinates" id="coordinates">
            Koordinat:
            <br>
            Latitude: Loading...
            <br>
            Longitude: Loading...
        </div>
    </div>

    <script>
    // Retrieve data from JSON response
    const responseData = {
        code: 200,
        status: "OK",
        data: {
            latitude: 25.4106386,
            longitude: -54.189238,
            direction: 68.92406695044804,
        }
    };

    // Update direction and coordinates
    const directionElement = document.getElementById("direction");
    const coordinatesElement = document.getElementById("coordinates");

    directionElement.textContent = responseData.data.direction.toFixed(2);
    coordinatesElement.innerHTML = `
            Koordinat:
            <br>
            Latitude: ${responseData.data.latitude.toFixed(7)}
            <br>
            Longitude: ${responseData.data.longitude.toFixed(7)}
        `;

    // Rotate needle to point to the direction
    const needleElement = document.querySelector(".needle");
    needleElement.style.transform = `translate(-50%, -100%) rotate(${responseData.data.direction.toFixed(2)}deg)`;
    </script>
</body>

</html>