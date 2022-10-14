<?php include_once '../includes/headNav.html.php'; ?>

<section class="section">
    <div class="columns is-centered">
        <div class="column is-two-thirds">
            <h2 class="title is-1 has-text-centered">camera</h2>
            <div class="container is-fluid">
                <div class="card">
                    <div class="block has-text-centered" id="captureImage">
                        <header class="card-header">
                            <h2 class="card-header-title">Photobooth Options</h2>
                            <button class="card-header-icon" aria-label="more options">
                            <span class="icon">
                                <img src="../public/icons/MaterialIcons/icons8-expand-arrow-48.png" alt="Options"
                                     title="More Options">
                            </span>
                            </button>
                        </header>

                        <div class="content" id="stickers">

                        </div>

                        <div class="content" id="cameraView">
                            <video id="video" autoplay muted></video>
                            <canvas id="canvas" hidden></canvas>
                        </div>

                        <div class="field">
                            <div class="control">
                                <textarea class="input" id="imageDescription" type="text" name="imageDescription" placeholder="Image Description"></textarea>
                            </div>
                            <?php if (isset($_GET['email_error'])) { ?>
                                <p class="help is-danger"><?php echo $_GET['comment_error']; ?> </p>
                            <?php } ?>
                        </div>

                        <footer class="card-footer p-2">
                            <a class="card-footer-item mx-2 button is-medium is-rounded is-success is-light is-responsive" id="captureButton" type="submit">
                                Capture
                            </a>
                            <a class="card-footer-item mx-2 button is-medium is-rounded is-link is-light is-responsive" id="uploadButton" type="submit">
                                Upload
                            </a>
                            <a class="card-footer-item mx-2 button is-medium is-rounded is-danger is-light is-responsive" id="cancelButton" type="submit">
                                Cancel
                            </a>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="container" id="cameraContainer">
        <div class="columns">
            <div class="column is-3">
                <div class="card">
                    <label class="label has-text-centered">Controls</label>
                    <button class="button is-fullwidth">Filters</button>
                    </br>
                    <button class="button is-fullwidth">Stickers</button>
                    </br>
                    <button class="button is-fullwidth">Save</button>
                    </br>
                    <button class="button is-fullwidth">Upload</button>
                </div>
            </div>
            <div class="column is-5">
                <div class="row text-center">
                    <div class="card">
                        <div id="captureImage">
                            <label class="label has-text-centered">Camera</label>
                            <div class="camera">
                                <video id="video" autoplay muted>Video stream not available.</video>
                            </div>
                        </div>

                        <div class="controls">
                            <button class="button is-primary is-fullwidth" id="captureButton">Capture</button>
                        </div>

                        <form id="imageDescription" action="../controllers/camera.php" method="post">
                            <div class="field mt-5">
                                <label class="label has-text-centered" for="imageDescription">Image Description</label>
                                <div class="control">
                                    <input class="input" id="imageDescription" type="text" name="imageDescription" placeholder="Image Description">
                                    <p class="is-size-7"><span class="count" id="counter">255</span> characters remaining.</p>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <button class="button is-primary is-fullwidth" type="submit" value="Post">Post</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="card">
                    <label class="label has-text-centered">Photos</label>
                    <img src="../public/stickers/bolt.png">
                </div>
            </div>
        </div>
    </div>-->
</section>
<?php include_once '../includes/footer.html.php'; ?>

<script src="../public/scripts/camera.js"></script>

