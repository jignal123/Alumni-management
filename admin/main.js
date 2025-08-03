import {
	ClassicEditor,
	AccessibilityHelp,
	Alignment,
	Autoformat,
	AutoLink,
	Autosave,
	BalloonToolbar,
	BlockQuote,
	Bold,
	CodeBlock,
	Essentials,
	FindAndReplace,
	FontBackgroundColor,
	FontColor,
	FontFamily,
	FontSize,
	GeneralHtmlSupport,
	Heading,
	Highlight,
	HorizontalLine,
	Indent,
	IndentBlock,
	Italic,
	Link,
	Paragraph,
	RemoveFormat,
	SelectAll,
	SpecialCharacters,
	SpecialCharactersArrows,
	SpecialCharactersCurrency,
	SpecialCharactersEssentials,
	SpecialCharactersLatin,
	SpecialCharactersMathematical,
	SpecialCharactersText,
	Style,
	Table,
	TableCaption,
	TableCellProperties,
	TableColumnResize,
	TableProperties,
	TableToolbar,
	TextTransformation,
	Underline,
	Undo
} from 'ckeditor5';

const editorConfig = {
	toolbar: {
		items: [
			'undo',
			'redo',
			'|',
			'findAndReplace',
			'selectAll',
			'|',
			'heading',
			'style',
			'|',
			'fontSize',
			'fontFamily',
			'fontColor',
			'fontBackgroundColor',
			'|',
			'bold',
			'italic',
			'underline',
			'removeFormat',
			'|',
			'specialCharacters',
			'horizontalLine',
			'link',
			'insertTable',
			'highlight',
			'blockQuote',
			'codeBlock',
			'|',
			'alignment',
			'|',
			'indent',
			'outdent',
			'|',
			'accessibilityHelp'
		],
		shouldNotGroupWhenFull: false
	},
	plugins: [
		AccessibilityHelp,
		Alignment,
		Autoformat,
		AutoLink,
		Autosave,
		BalloonToolbar,
		BlockQuote,
		Bold,
		CodeBlock,
		Essentials,
		FindAndReplace,
		FontBackgroundColor,
		FontColor,
		FontFamily,
		FontSize,
		GeneralHtmlSupport,
		Heading,
		Highlight,
		HorizontalLine,
		Indent,
		IndentBlock,
		Italic,
		Link,
		Paragraph,
		RemoveFormat,
		SelectAll,
		SpecialCharacters,
		SpecialCharactersArrows,
		SpecialCharactersCurrency,
		SpecialCharactersEssentials,
		SpecialCharactersLatin,
		SpecialCharactersMathematical,
		SpecialCharactersText,
		Style,
		Table,
		TableCaption,
		TableCellProperties,
		TableColumnResize,
		TableProperties,
		TableToolbar,
		TextTransformation,
		Underline,
		Undo
	],
	balloonToolbar: ['bold', 'italic', '|', 'link'],
	fontFamily: {
		supportAllValues: true
	},
	fontSize: {
		options: [10, 12, 14, 'default', 18, 20, 22],
		supportAllValues: true
	},
	heading: {
		options: [
			{
				model: 'paragraph',
				title: 'Paragraph',
				class: 'ck-heading_paragraph'
			},
			{
				model: 'heading1',
				view: 'h1',
				title: 'Heading 1',
				class: 'ck-heading_heading1'
			},
			{
				model: 'heading2',
				view: 'h2',
				title: 'Heading 2',
				class: 'ck-heading_heading2'
			},
			{
				model: 'heading3',
				view: 'h3',
				title: 'Heading 3',
				class: 'ck-heading_heading3'
			},
			{
				model: 'heading4',
				view: 'h4',
				title: 'Heading 4',
				class: 'ck-heading_heading4'
			},
			{
				model: 'heading5',
				view: 'h5',
				title: 'Heading 5',
				class: 'ck-heading_heading5'
			},
			{
				model: 'heading6',
				view: 'h6',
				title: 'Heading 6',
				class: 'ck-heading_heading6'
			}
		]
	},
	htmlSupport: {
		allow: [
			{
				name: /^.*$/,
				styles: true,
				attributes: true,
				classes: true
			}
		]
	},
	initialData:
		"",
	link: {
		addTargetToExternalLinks: true,
		defaultProtocol: 'https://',
		decorators: {
			toggleDownloadable: {
				mode: 'manual',
				label: 'Downloadable',
				attributes: {
					download: 'file'
				}
			}
		}
	},
	placeholder: 'Type or paste your content here!',
	style: {
		definitions: [
			{
				name: 'Article category',
				element: 'h3',
				classes: ['category']
			},
			{
				name: 'Title',
				element: 'h2',
				classes: ['document-title']
			},
			{
				name: 'Subtitle',
				element: 'h3',
				classes: ['document-subtitle']
			},
			{
				name: 'Info box',
				element: 'p',
				classes: ['info-box']
			},
			{
				name: 'Side quote',
				element: 'blockquote',
				classes: ['side-quote']
			},
			{
				name: 'Marker',
				element: 'span',
				classes: ['marker']
			},
			{
				name: 'Spoiler',
				element: 'span',
				classes: ['spoiler']
			},
			{
				name: 'Code (dark)',
				element: 'pre',
				classes: ['fancy-code', 'fancy-code-dark']
			},
			{
				name: 'Code (bright)',
				element: 'pre',
				classes: ['fancy-code', 'fancy-code-bright']
			}
		]
	},
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
	}
};
let aeditor;
ClassicEditor.create(document.querySelector('#description'), editorConfig).then(createdEditor =>{
	aeditor = createdEditor;
});
let editor;
$(document).on("click", ".update", function () {
	var e_id = $(this).attr("id");
	$.ajax({
		type: "post",
		url: "admin_backend.php",
		data: { e_id: e_id },
		dataType: "json",
		success: function (data) {
			$("#editmodal").modal("show");
			$("#etitle").val(data.title);
			$("#estart").val(data.start);
			$("#eend").val(data.end);
			$("#eloc").val(data.loc);
			$("#estatus").val(data.status);
			$("#hidden_img").val(data.himg);
			if (!editor) {  // Check if editor already exists
				ClassicEditor.create(document.querySelector('#edescription'), editorConfig)
				  .then(createdEditor => {
					editor = createdEditor; // Store the editor instance
					editor.setData(data.des);
				  });
				  
			  } else {
				editor.setData(data.des); // Set new data
			  }		
			$("#upload-image").html(data.img);
			$("#ev_id").val(e_id);
		}
	});
});
$("#add").on("click", function (e) {
	//alert($(".ck-content").html());
	checktitle();
	checkstart();
	checkend();
	checklocation();
	checkimage();
	title.addEventListener("keyup", checktitle);
	start.addEventListener("change", checkstart);
	end.addEventListener("change", checkend)
	loc.addEventListener("keyup", checklocation);
	image.addEventListener("change", checkimage);
	if (submitf(form) == true) {
		e.preventDefault();
		Swal.fire({
			title: "Are you sure to submit?",
			icon: "warning",
			showClass: {
				popup: `
			animate__animated
			animate__fadeInDown
			animate__faster
		  `
			},
			hideClass: {
				popup: `
			 animate__animated
			 animate__fadeOutUp
			 animate__faster
		   `
			},
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes!"
		}).then((result) => {
			if (result.isConfirmed) {
				var formdata = new FormData(form);
				var des = aeditor.getData();
				formdata.append("description", des);
				$('.loader').show();
				$("#eventmodal").modal('hide');
				$.ajax({
					type: "POST",
					url: "admin_backend.php",
					data: formdata,
					contentType: false,
					processData: false,
					success: function (data) {
						if (data == "add") {
							$('.loader').hide();
							Swal.fire({
								title: "Added!",
								text: "Event added Successfully",
								icon: "success",
								showClass: {
									popup: `
							animate__animated
							animate__fadeInDown
							animate__faster
						  `
								},
								hideClass: {
									popup: `
							 animate__animated
							 animate__fadeOutUp
							 animate__faster
						   `
								}
							}).then((result) => {
							if (result.isConfirmed) {
								window.location.assign("add_event.php");
							}
						});

						} else {
							$('.loader').hide();
							Swal.fire({
								title: "Error!",
								text: "Error In adding event",
								icon: "error",
								showClass: {
									popup: `
							animate__animated
							animate__fadeInDown
							animate__faster
						  `
								},
								hideClass: {
									popup: `
							 animate__animated
							 animate__fadeOutUp
							 animate__faster
						   `
								}
							}).then((result) => {
							if (result.isConfirmed) {
								window.location.assign("add_event.php");
							}
						});
						}
					}
				});
			}
		});
	}
	else {
		e.preventDefault();
	}
});
$("#edit").on("click", function (e) {
	//alert($(".ck-content").html());
	checketitle();
	checkestart();
	checkeend();
	checkelocation();
	checkeimage();
	etitle.addEventListener("keyup", checketitle);
	estart.addEventListener("change", checkestart);
	eend.addEventListener("change", checkeend)
	eloc.addEventListener("keyup", checkelocation);
	eimage.addEventListener("change", checkeimage);
	if (submitf(eform) == true) {
		e.preventDefault();
		Swal.fire({
			title: "Are you sure to save changes?",
			icon: "warning",
			showClass: {
				popup: `
			animate__animated
			animate__fadeInDown
			animate__faster
		  `
			},
			hideClass: {
				popup: `
			 animate__animated
			 animate__fadeOutUp
			 animate__faster
		   `
			},
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes!"
		}).then((result) => {
			if (result.isConfirmed) {
				var formdata = new FormData(eform);
				var des = editor.getData();
				formdata.append("edescription", des);
				$('.loader').show();
				$("#editmodal").modal('hide');
				$.ajax({
					type: "POST",
					url: "admin_backend.php",
					data: formdata,
					contentType: false,
					processData: false,
					success: function (data) {
						$("#editform")[0].reset();
						$("#event_data").DataTable().ajax.reload();
						if (data == "edit") {
							$('.loader').hide();
							Swal.fire({
								title: "Edited!",
								text: "Event Updated Successfully",
								icon: "success",
								showClass: {
									popup: `
							animate__animated
							animate__fadeInDown
							animate__faster
						  `
								},
								hideClass: {
									popup: `
							 animate__animated
							 animate__fadeOutUp
							 animate__faster
						   `
								}
							})

						} else {
							$('.loader').hide();
							Swal.fire({
								title: "Error!",
								text: "Error In Updating Event",
								icon: "error",
								showClass: {
									popup: `
							animate__animated
							animate__fadeInDown
							animate__faster
						  `
								},
								hideClass: {
									popup: `
							 animate__animated
							 animate__fadeOutUp
							 animate__faster
						   `
								}
							})
						}
					}
				});
			}
		});
	}
	else {
		e.preventDefault();
	}
});


