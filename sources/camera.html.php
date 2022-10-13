<?php include_once '../includes/headNav.html.php'; ?>

<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-3">
                <label class="label has-text-centered">Controls</label>
                <button class="button is-fullwidth">Filters</button>
                </br>
                <button class="button is-fullwidth">Stickers</button>
                </br>
                <button class="button is-fullwidth">Save</button>
                </br>
                <button class="button is-fullwidth">Upload</button>
                </br>
                <button class="button is-fullwidth">Download</button>
                </br>
                <button class="button is-fullwidth">Delete</button>
            </div>
            <div class="column is-5">
                <div class="box">
                    <label class="label has-text-centered">Camera</label>
                    <div class="camera">
                        <video id="video">Video stream not available.</video>
                    </div>
                    <div class="controls">
                        <button class="button is-fullwidth" id="startbutton">Capture</button>
                    </div>
                </div>
                <div class="box">
                    <canvas id="canvas">
                        <div class="output">
                            <img id="photo" alt="The screen capture will appear in this box.">
                        </div>
                    </canvas>
                </div>
            </div>
            <div class="column is-3">
                <label class="label has-text-centered">Photos</label>
                <img src="../public/stickers/bolt.png">
            </div>
        </div>
    </div>
</section>
<footer class="footer is-white">
    <div class="content has-text-centered">
        <p>
            &#169 2022 <strong>camagru</strong> from <a href="https://balbaugh.com">balbaugh</a>
        </p>
    </div>
</footer>
</body>
<script src="../public/scripts/camera.js"></script>
</html>
<?php include_once '../includes/footer.html.php'; ?>
