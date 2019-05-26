<script src="../../Scripts/preview.js"></script>

<div class="container">

	<!-- main div to add new task -->
	<div class="row text-center">
	    <div class="col-md-9">
			<form enctype="multipart/form-data" method="POST">
				<div class="form-group">
					<input class="form-control" type="text" name="user_name" id="user_name" placeholder="User name" required />
				</div>
				<div class="form-group">
					<input class="form-control" type="email" name="user_email" id="user_email" placeholder="Email" required />
				</div>
				<div class="form-group">
					<textarea class="form-control" rows="4" cols="30" name="text" id="text" placeholder="Your task" required ></textarea>
					<!-- <input class="form-control" type="textarea" name="text" placeholder="Your task" /> -->
				</div>
				<div class="form-group">
					<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
					<input name="task_img" id="task_img" type="file" accept=".gif, .jpg, .png" />
					<span id="task_img-clone-area"><input type="hidden" name="task_img-clone" id="task_img-clone" type="file" accept=".gif, .jpg, .png" /></span>
				</div>
				<input class="form-control submit" type="submit" name="submit" value="Add" />
			</form>
			<br>
			<button id="preview-btn" class="form-control">Preview</button>
		</div>
	</div>

	<!-- preview div -->
	<div id="preview-div" style="visibility: hidden;">
		<div class="row is-table-row">

			<div class="col-sm-9 bg-danger">
				<h3 id="text-preview"></h3>
				<h4 id="user_name-preview"></h4>
				<small id="user_email-preview"></small>
			</div>

			<div class="col-sm-3 bg-success text-center">
				<img id="task_img-preview" src="#" class="img-responsive center-block" alt="Add image to see here" width="320" height="240">
			</div>

		</div>
	</div>


</div>