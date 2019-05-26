<div class="container">

    <!-- Sort by tags section -->
    <div class="row">
        <div class="col-sm-12 text-center">
            Sort by:
            <a href="?sort=username">
                <div class="btn <?php if($_GET['sort'] == 'username') { echo 'bg-success'; } ?>">User name</div>
            </a>
            <a href="?sort=email">
                <div class="btn <?php if($_GET['sort'] == 'email') { echo 'bg-success'; } ?>">Email</div>
                <a href="?sort=status">
                    <div class="btn <?php if($_GET['sort'] == 'status') { echo 'bg-success'; } ?>">Status</div>
                </a>
        </div>
    </div>
    <!-- List of tasks -->
    <?php foreach ($this->tasksList as $task):?>
        <div class="row is-table-row">

            <div class="col-sm-9 <?php echo ($task['status'] == 1 ? 'bg-info' : 'bg-danger') ?>">
                <?php if(!empty($_SESSION) && $_SESSION['admin'] ): ?>
                    <form  method="post">
                    <input type="hidden" id ="taskid" name="taskid" value=<?=$task['id']?> >
                    <input type="checkbox" id="status" name="status" value=<?=$task['status']?> <?php if ($task['status']==1) echo'checked'; ?> /><label for="done">done</label>
                <?php endif; ?>

                <?php if(!empty($_SESSION) && $_SESSION['admin'] ): ?>
                    <h3> <?php echo '<input type="text" id="description" name="description" value ='.$task['description'];'>'?> </h3>
                <?php else :?>
                <h3> <?php echo $task['description'];?> </h3>
                <?php endif; ?>

                <h4><?php echo $task['username'] ?>
                    <small> <?php echo $task['email']; ?> </small>
                </h4>

            </div>

            <?php if(isset($task['picture'])): ?>
                <div class="col-sm-3 bg-success text-center" id="task-img"> Preview
                    <img src="<?php echo $task['picture'];?>" class="img-responsive center-block">
                </div>
            <?php endif; ?>

            <?php if(!empty($_SESSION) && $_SESSION['admin'] ): ?>
                <!-- show Save btn for admin -->
                <p><input type="submit" class="btn" value="SAVE"/></p>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach;?>
    <!-- Pagination -->
    <div class="row">
        <div class="col-sm-12 text-center">

            <?php for ($i=1; $i <= $this->numberOfPages; $i++): ?>
                <a href='<?php echo "/tasks/page/$i" . (isset($_GET["sort"]) ? "?sort=" . $_GET["sort"] : ""); ?>' >
                    <div class="btn <?php if($i != $this->pageNumber) { echo 'bg-success'; } ?>"> <?php echo $i ?></div>
                </a>
            <?php endfor; ?>

        </div>
    </div>
</div>
</html>