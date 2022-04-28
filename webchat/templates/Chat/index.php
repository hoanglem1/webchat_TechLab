<style>
.imagebox {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 300px;
}

.slide {
    width: auto;
    height: 100px;
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
}

.avartar {
    background-color: #f8fafc;
    border: 1px solid #dbdbdb;
    border-radius: 50% 50% 0 50%;
    box-sizing: border-box;
    color: #1a1a1a;
    display: flex;
    height: 32px;
    justify-content: center;
    line-height: 19.5px;
    overflow: hidden;
    padding: 0;
    width: 32px;
}

.ignore-css {
    width: 50px;
    height: 50px;
    all: unset;
}

video {
    max-width: 600px;
    height: 100%;
}
</style>
<?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'feed']]); ?>
<div class="slide">
    <?php
    for ($x = 1; $x <= 24; $x++) {
        echo '<button class="ignore-css" type="submit" name="stamp_id" value=' . $x . '>';
        echo $this->Html->image("stamp/" . $x . ".png", ['alt' => 'image', 'type' => 'image', 'value' => $x]);
        echo '</button>';
    }
    ?>
</div>
<div class="flex" style="justify-content: space-between;">
    <div>
        <span><label class="custom-file-upload"><input id="image_upload" name="image" type="file"
                    onchange="showimage()" />Ảnh</label></span>
        <span><label class="custom-file-upload"><input id="video_upload" name="video" type="file"
                    onchange="showvideo()" />Video</label></span>
    </div>
    <div><input class="submit" value="Gửi" type="submit"></div>
</div>

<img id="blah" src="#" class="imagebox" alt="image upload" style="display:none" />
<video id="blvh" src="#" type="video/mp4" style="display:none" width="320" height="240" controls>
    Your browser does not support the video tag.
</video>

<div class="flex">
    <?php
    echo $this->Form->control('message', ['rows' => '3', 'label' => false, 'placeholder' => "Nhập tin nhắn ở đây", 'style' => 'width:100%;']);
    echo $this->Form->end();
    ?>
</div>
<div class="chatbox" id="chatbox">
    <?php foreach ($t_feed as $t_feed) : ?>
    <div class="bound">

        <div class="flex" style="justify-content: space-between;">
            <div class="name">
                <?= $t_feed->name . '' ?>
            </div>
            <div class="post_time">
                <?= $t_feed->create_at->format('d/m H:i') ?>
                <span>
                    <?= "Posted:" . $t_feed->create_at->format('d/m/Y H:i') ?>
                    <br>
                    <?= "Edited:" . $t_feed->update_at->format('d/m/Y H:i') ?>
                </span>
            </div>
        </div>
        <p>
        <div>
            <span style="word-wrap: break-word">
                <?= nl2br($t_feed->message) ?>
            </span>

        </div>
        </p>
        <?php
            //Display video and image
            if ($t_feed->image_file_name) {
                if (substr($t_feed->image_file_name, 0, 5) == 'video') {
                    echo "<div class=\"video\">";
                    echo $this->Html->media($t_feed->image_file_name, ['alt' => 'video', 'controls' => true, 'type' => "video/mp4"]);
                    echo "</div>";
                } else {
                    echo "<div class=\"imagebox\">";
                    echo $this->Html->image($t_feed->image_file_name, ['alt' => 'image']);
                    echo '<a href="/img/' . $t_feed->image_file_name . '" download >' . substr(substr($t_feed->image_file_name, 7), -12, 12) . '</a>';
                    echo "</div>";
                }
            }
            //Stamp list
            if ($t_feed->stamp_id) {
                echo $this->Html->image("stamp/" . $t_feed->stamp_id . ".png", ['alt' => 'image', 'type' => 'stamp']);
            }
            //Edit and delete own feed
            if ($t_feed->user_id == $user_id) {
                echo '<div class="edit_delete">';
                echo $this->Html->link('Edit', ['action' => 'edit', $t_feed->id]);
                echo '&nbsp';
                echo $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $t_feed->id],
                    ['confirm' => 'Are you sure?']
                );
                echo '</div>';
            }
            ?>
        <br>
    </div>
    <?php endforeach; ?>
</div>
<script>
//Go to bottom of the chat
setTimeout(() => {
    document.getElementById("chatbox").scrollTop = document.getElementById("chatbox").scrollHeight;
}, 100);
//Preview image
function showimage() {
    var name = document.getElementById('image_upload');
    const [file] = name.files
    if (file) {
        blah.src = URL.createObjectURL(file);
        blah.style.display = "block";
    }
};
//Preview video
function showvideo() {
    var name = document.getElementById('video_upload');
    const [file] = name.files
    if (file) {
        blvh.src = URL.createObjectURL(file);
        blvh.style.display = "block";
    }
};
</script>
<!-- POST FORM -->