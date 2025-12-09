/*global $, window*/
var cancelEditorType = ["button", "checkbox"];
$.fn.editableTableWidget = function (options) {
	'use strict';
	return $(this).each(function () {
		var builCustomOptions = function () {
			if (!options) {
				var ed = $("<input>");
				$("body").append(ed);
				return { editor: ed };
			}
			var opts = $.extend({}, options);
			opts.editor = opts.editor.clone();
			return opts;
		},
			buildDefaultOptions = function () {
				var opts = $.extend({}, $.fn.editableTableWidget.defaultOptions);
				opts.editor = opts.editor.clone();
				return opts;
			},
			activeOptions = $.extend(buildDefaultOptions(), builCustomOptions()),
			ARROW_LEFT = 37, ARROW_UP = 38, ARROW_RIGHT = 39, ARROW_DOWN = 40, ENTER = 13, ESC = 27, TAB = 9, BACK_SPACE = 8, DELETE = 46,
			CTRL = 17, CTRL_C = 67, CTRL_V = 86,
			element = $(this),
			editor = activeOptions.editor.css({ "position": "absolute", "z-index": "2" }).hide().appendTo(element.parent()),
			active,
			showEditor = function (select, keyInput) {
				editor.val('');
				active = element.find('td.focus');
				if (active.length) {
					var isDateTime = false;
					var header = element.find('th:eq(' + active.index() + ')');
					if (header.hasClass('data-type-datetime')) {
						isDateTime = true;
						editor.datepicker("destroy");
						editor.datetimepicker({
							controlType: 'select',
							oneLine: true,
							dateFormat: 'dd/mm/yy',
							timeFormat: 'HH:mm:ss',
							timeInput: true,
							hour: 23,
							minute: 59,
							second: 59,
							onClose: function () {
								editor.trigger('blur');
								editor.hide();

								active.trigger('click');
							}
						});
					} else if (header.hasClass('data-type-date')) {
						isDateTime = true;
						editor.datetimepicker("destroy");
						editor.datepicker({
							controlType: 'select',
							oneLine: true,
							dateFormat: 'dd/mm/yy',
							timeInput: true,
							onClose: function () {
								editor.trigger('blur');
								editor.hide();
								active.trigger('click');
							}
						});
					} else {
						isDateTime = false;
						editor.datepicker("destroy");
						editor.datetimepicker("destroy");
					}

					if (header.attr('max-length')) {
						editor.attr('maxLength', header.attr('max-length'));
					}
					else {
						editor.removeAttr('maxLength');
					}

					var check = editor.data('ui-autocomplete') != undefined;

					if (check) {
						editor.autocomplete("destroy");
					}

					if (header.hasClass('autocomplete')) {
						var tblID = header.closest("table").attr("id"),
							tableHeader = active.closest("table").parent().prev().find('table');

						if (tableHeader) {
							var srcAttr = tableHeader.find("th:eq(" + active.index() + ")").attr("select-source");
							var src = srcAttr ? JSON.parse(srcAttr) : [];
							var isArr = $.isArray(src);

							var compeleteSrc = !isArr ? Object.values(src) : src;
							editor.autocomplete({
								source: compeleteSrc,
								minLength: 1
								// create: function( event, ui ) {
								// 	$(document).find('.ui-helper-hidden-accessible').remove();
								// 	$(c).parent().closest('tr').addClass('m-row-selected');
								// }
							});
						}
					}

					// alert(1);
					// alert(active.text());	

					var n;
					if (!keyInput) {
						n = editor.is('select') ? active.find('input:first').val() : active.text();
					} else {
						n = (!isDateTime) ? keyInput : "";
					}

					if (header.hasClass('data-type-numeric')) {
						if (!n) {
							n = "0";
						}
						n = n.split(",").join("").replace(".00", "");
					}

					var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;

					if (isFirefox || (!keyInput && n != "")) {
						editor.val(n);
					}

					editor
						.removeClass('error')
						.show()
						.offset(active.offset())
						.css(active.css(activeOptions.cloneProperties)) //double chữ ở chrome ở đây nè
						.width(active.width())
						.height(active.height())
						.focus();

					if (select) {
						editor.select();
					}
				}
			},
			setActiveText = function () {
				var text = editor.val(),
					evt = $.Event('change'),
					originalContent;
				if (active.text() === text || editor.hasClass('error')) {
					return true;
				}
				originalContent = active.html();
				active.text(text).trigger(evt, text);
				if (evt.result === false) {
					active.html(originalContent);
				}
			},
			movement = function (element, keycode) {
				if (keycode === ARROW_RIGHT) {
					return element.next('td');
				} else if (keycode === ARROW_LEFT) {
					return element.prev('td');
				} else if (keycode === ARROW_UP) {
					return element.parent().prev().children().eq(element.index());
				} else if (keycode === ARROW_DOWN) {
					return element.parent().next().children().eq(element.index());
				}
				return [];
			};

		editor
			.blur(function () {
				if (editor.is(":hidden")) {
					return;
				}

				setActiveText();
				var str = editor.is('select') ? '<input class="hidden-input" value="' + editor.val() + '"/>' + editor.find(':selected').text() : editor.val();
				var tbl = $(active).closest('table').DataTable();

				str = str ? str.trim() : "";

				if (editor.data('ui-autocomplete')) {
					var atcplSource = editor.data('ui-autocomplete').options.source;
					if (atcplSource && atcplSource.length > 0) {
						if (atcplSource.indexOf(str) < 0 && atcplSource.indexOf(str.toUpperCase()) < 0) {
							toastr["error"]("Dữ liệu nhập vào không đúng!");
							$(active).addClass("error");
							tbl.cell(active).data("");
							editor.hide();

							active.focus();

							return;
						}
					}
				}

				$(active).removeClass("error");

				var headerEditing = element.parent().prev().find("table").find("thead th:eq(" + active.index() + ")");

				//check cont iso
				var colName = headerEditing.attr("col-name");
				if (colName == "CntrNo") {
					if (!editor.check_cont_iso()) {
						toastr["error"]("Container không đúng chuẩn ISO!");
						$(active).addClass("error");
					}
				}

				/// cat bo phan thap phan theo do dai duoc dinh nghia float-nums 1.3455555 -> 1.345
				if (headerEditing.hasClass('data-type-numeric')) {
					var maxFloatNum = parseInt(headerEditing.attr('float-nums') || 0);
					if (maxFloatNum > 0) {
						var indexOfFloat = String(str).indexOf(".");
						if (indexOfFloat >= 0) {
							str = parseFloat(String(str).substring(0, (indexOfFloat + 1) + maxFloatNum));
						}
					}
				}

				tbl.cell(active).data(str).draw(false);

				active.trigger("change");

				var urowIdx = tbl.cell(active).index().row;
				var crow = tbl.row(urowIdx).nodes().to$();
				if (!crow.hasClass("addnew")) {
					crow.addClass("editing");
				}

				if (headerEditing.hasClass('data-type-date')
					|| headerEditing.hasClass('data-type-datetime')) {
					return;
				}

				editor.hide();
			})
			.keydown(function (e) {
				if (e.which === ENTER) {
					setActiveText();
					var str = editor.is('select') ? '<input class="hidden-input" value="' + editor.val() + '"/>' + editor.find(':selected').text() : editor.val();

					var tbl = $(active).closest('table').DataTable();

					str = str ? str.trim() : "";

					if (editor.data('ui-autocomplete')) {
						var atcplSource = editor.data('ui-autocomplete').options.source;
						if (atcplSource && atcplSource.length > 0) {
							if (atcplSource.indexOf(str) < 0 && atcplSource.indexOf(str.toUpperCase()) < 0) {
								toastr["error"]("Dữ liệu nhập vào không đúng!");
								$(active).addClass("error");
								tbl.cell(active).data("");
								editor.hide();

								active.focus();

								return;
							}
						}
					}

					$(active).removeClass("error");

					//check cont iso
					var headerEditing = element.find("thead th:eq(" + active.index() + ")");
					var colName = headerEditing.attr("col-name");
					if (colName == "CntrNo") {
						if (!editor.check_cont_iso()) {
							toastr["error"]("Container không đúng chuẩn ISO!");
							$(active).addClass("error");
						}
					}

					/// cat bo phan thap phan theo do dai duoc dinh nghia float-nums 1.3455555 -> 1.345
					if (headerEditing.hasClass('data-type-numeric')) {
						var maxFloatNum = parseInt(headerEditing.attr('float-nums') || 0);
						if (maxFloatNum > 0) {
							var indexOfFloat = String(str).indexOf(".");
							if (indexOfFloat >= 0) {
								str = parseFloat(String(str).substring(0, (indexOfFloat + 1) + maxFloatNum));
							}
						}
					}

					tbl.cell(active).data(str).draw(false);

					active.trigger("change");

					var urowIdx = tbl.cell(active).index().row;
					var crow = tbl.row(urowIdx).nodes().to$();
					if (!crow.hasClass("addnew")) {
						crow.addClass("editing");
					}

					editor.hide();
					active.focus();
					e.preventDefault();
					e.stopPropagation();
				} else if (e.which === ESC) {
					editor.val(active.text());
					e.preventDefault();
					e.stopPropagation();
					editor.hide();
					active.focus();
				} else if (e.which === TAB) {
					setActiveText();
					var str1 = editor.is('select') ? '<input class="hidden-input" value="' + editor.val() + '"/>' + editor.find(':selected').text() : editor.val();

					var tbl = $(active).closest('table').DataTable();

					str1 = str1 ? str1.trim() : "";

					if (editor.data('ui-autocomplete')) {
						var atcplSource = editor.data('ui-autocomplete').options.source;
						if (atcplSource && atcplSource.length > 0) {
							if (atcplSource.indexOf(str1) < 0 && atcplSource.indexOf(str1.toUpperCase()) < 0) {
								toastr["error"]("Dữ liệu nhập vào không đúng!");
								$(active).addClass("error");
								tbl.cell(active).data("");
								editor.hide();

								active.focus();

								return;
							}
						}
					}

					$(active).removeClass("error");

					//check cont iso
					var headerEditing = element.find("thead th:eq(" + active.index() + ")");
					var colName = headerEditing.attr("col-name");
					if (colName == "CntrNo") {
						if (!editor.check_cont_iso()) {
							toastr["error"]("Container không đúng chuẩn ISO!");
							$(active).addClass("error");
						}
					}

					/// cat bo phan thap phan theo do dai duoc dinh nghia float-nums 1.3455555 -> 1.345
					if (headerEditing.hasClass('data-type-numeric')) {
						var maxFloatNum = parseInt(headerEditing.attr('float-nums') || 0);
						if (maxFloatNum > 0) {
							var indexOfFloat = String(str1).indexOf(".");
							if (indexOfFloat >= 0) {
								str1 = parseFloat(String(str1).substring(0, (indexOfFloat + 1) + maxFloatNum));
							}
						}
					}

					tbl.cell(active).data(str1).draw(false);

					active.trigger("change");

					var urowIdx = tbl.cell(active).index().row;
					var crow = tbl.row(urowIdx).nodes().to$();
					if (!crow.hasClass("addnew")) {
						crow.addClass("editing");
					}

					editor.hide();
					active.focus();
					e.preventDefault();
					e.stopPropagation();
				} else if (e.which === ARROW_LEFT || e.which === ARROW_UP || e.which === ARROW_RIGHT || e.which === ARROW_DOWN) {
					var possibleMove = movement(active, e.which);
					if (possibleMove.length > 0) {
						setActiveText();
						var str1 = editor.is('select') ? '<input class="hidden-input" value="' + editor.val() + '"/>' + editor.find(':selected').text() : editor.val();

						var tbl = $(active).closest('table').DataTable();

						str1 = str1 ? str1.trim() : "";

						if (editor.data('ui-autocomplete')) {
							var atcplSource = editor.data('ui-autocomplete').options.source;
							if (atcplSource && atcplSource.length > 0) {
								if (atcplSource.indexOf(str1) < 0 && atcplSource.indexOf(str1.toUpperCase()) < 0) {
									toastr["error"]("Dữ liệu nhập vào không đúng!");
									$(active).addClass("error");
									tbl.cell(active).data("");
									editor.hide();

									active.focus();

									return;
								}
							}
						}

						$(active).removeClass("error");

						//check cont iso
						var headerEditing = element.find("thead th:eq(" + active.index() + ")");
						var colName = headerEditing.attr("col-name");
						if (colName == "CntrNo") {
							if (!editor.check_cont_iso()) {
								toastr["error"]("Container không đúng chuẩn ISO!");
								$(active).addClass("error");
							}
						}

						/// cat bo phan thap phan theo do dai duoc dinh nghia float-nums 1.3455555 -> 1.345
						if (headerEditing.hasClass('data-type-numeric')) {
							var maxFloatNum = parseInt(headerEditing.attr('float-nums') || 0);
							if (maxFloatNum > 0) {
								var indexOfFloat = String(str1).indexOf(".");
								if (indexOfFloat >= 0) {
									str1 = parseFloat(String(str1).substring(0, (indexOfFloat + 1) + maxFloatNum));
								}
							}
						}

						tbl.cell(active).data(str1).draw(false);

						active.trigger("change");

						var urowIdx = tbl.cell(active).index().row;
						var crow = tbl.row(urowIdx).nodes().to$();
						if (!crow.hasClass("addnew")) {
							crow.addClass("editing");
						}

						editor.hide();
						possibleMove.focus().active();
						e.preventDefault();
						e.stopPropagation();
					}
				} else if (this.selectionEnd - this.selectionStart === this.value.length) {
					var possibleMove = movement(active, e.which);
					if (possibleMove.length > 0) {
						possibleMove.focus();
						e.preventDefault();
						e.stopPropagation();
					}
				}
			})
			.on('input paste keydown', function (e) {
				if (element.find('th:eq(' + active.index() + ')').hasClass('data-type-numeric')) {
					if (e.type == "keydown") {
						// Allow: backspace, delete, tab, escape, enter, . and -
						if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 188, 189]) !== -1 ||
							((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
							(e.keyCode >= 35 && e.keyCode <= 40)) {
							return;
						}
						// Ensure that it is a number and stop the keypress
						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
							e.preventDefault();
							return;
						}
					} else if (e.type == "paste") {
						var tempval = e.originalEvent.clipboardData.getData('Text').replace(',', '');
						editor.val($.isNumeric(tempval) ? tempval : "");

						e.preventDefault();
						return;
					}

					var maxFloatNum = parseInt(element.find('th:eq(' + active.index() + ')').attr('float-nums') || 0);
					if (maxFloatNum > 0) {
						var indexOfFloat = String(editor.val()).indexOf(".");
						if (indexOfFloat >= 0) {
							var lengthOfFLoat = String(editor.val().split('.')[1] || "").length + 1;
							if (lengthOfFLoat > maxFloatNum) {
								e.preventDefault();
								return;
							}
						}
					}
				}
				var evt = $.Event('validate');
				active.trigger(evt, editor.val());
				if (evt.result === false) {
					editor.addClass('error');
				} else {
					editor.removeClass('error');
				}
			});

		element
			.on('keypress dblclick', function (e) {
				var tdActive = element.find('td.focus'),
					thCurrent = element.find('th:eq(' + tdActive.index() + ')'),
					// editorID = thCurrent.attr('class').match(/editor-(.*) (.*)/),
					editTag = '',
					keyInput = '';

				
				if (e.type == "keypress") {
					if (thCurrent.hasClass('data-type-numeric') && !$.isNumeric(e.originalEvent.key) && e.originalEvent.key !== '-') {
						e.preventDefault();
						return;
					}
					
					if(e.which == 32 && tdActive.find('input[type="checkbox"]').length > 0){
						tdActive.find('input[type="checkbox"]').prop('checked', !tdActive.find('input[type="checkbox"]').prop('checked'));
					}

					keyInput = e.originalEvent.key;
				}
				
				if (thCurrent.hasClass('editor-cancel')) return;

				// if(editorID != null && editorID[1]){
				// 	var editorElem = editorID[1].split(" ")[0];
				// 	if($('#'+editorElem).length == 0) return;
				// 	editTag = editorElem;
				// 	keyInput = undefined;
				// }else{
				// 	editTag = "editor-input";
				// }

				editor = activeOptions.editor;
				// $.each(activeOptions.editor, function (idx, item) {
				// 	if($(item).attr('id') == editTag){
				// 		editor = $(item);
				// 	}
				// });
				showEditor(false, keyInput);
			})
			.keydown(function (e) {
				var prevent = false,
					tdActive = element.find('td.focus'),
					thCurrent = element.find('th:eq(' + tdActive.index() + ')');
				// // if (e.which === ENTER) {
				// // 	showEditor(false);
				// // } else if (e.which === 17 || e.which === 91 || e.which === 93) {
				// // 	showEditor(true);
				// // 	prevent = false;
				// // } else {
				// // 	prevent = false;
				// // }
				// if(e.which === BACK_SPACE || e.which === DELETE || e.which === TAB){
				// 	prevent = false;
				// }

				switch (e.which) {
					case ESC:
						prevent = true;
						break;
					case BACK_SPACE:
						prevent = true;
						element.DataTable().cell(tdActive).data('').draw(false);
						showEditor(false);
						break;
					case DELETE:
						if (thCurrent.hasClass('editor-cancel')) return;
						element.DataTable().cell(tdActive).data('').draw(false);
						tdActive.focus();
						prevent = true;
						break;
					case CTRL_C:
						if (e.ctrlKey || e.metaKey) {
							var el = document.createElement('textarea');
							el.value = element.DataTable().cell(tdActive).data();
							document.body.appendChild(el);
							el.select();
							document.execCommand('copy');
							document.body.removeChild(el);
							prevent = true;
						}

						break;
					default:
						prevent = false;
				}

				if (prevent) {
					e.stopPropagation();
					e.preventDefault();
				}
			});

		element.find('td').prop('tabindex', 1);

		$(window).on('resize', function () {
			if (editor.is(':visible')) {
				editor.offset(active.offset())
					.width(active.width())
					.height(active.height());
			}
		});

		$.pasteCell(function (e) {
			var tdActive = element.find('td.focus'),
				thCurrent = element.find('th:eq(' + tdActive.index() + ')'),
				editorID = thCurrent.attr('class').match(/editor-(.*) (.*)/),
				editTag = "editor-input",
				rowIdx = tdActive.parent().index(),
				colIdx = tdActive.index();

			var pasteMultiCol, pasteMultiRow;

			var pasteMultiRow = e.split(/(\r\n|\r|\n)/g),
				pasteMultiCol = e.split(/(\t)/g);

			if (pasteMultiRow.length > 1) {

				var row1 = rowIdx;

				$.each(pasteMultiRow, function (i1, v1) {

					var _multicol = v1.split(/(\t)/g);

					if (_multicol.length > 1) {
						var col1 = colIdx;
						$.each(_multicol, function (i2, v2) {

							if (v2 === "\n" || v2 === "\r\n" || v2 === "\r" || v2 === "\t") return;

							fillValues(row1, col1, v2);

							col1 += 1;
						});
					} else {
						if (v1 === "\n" || v1 === "\r\n" || v1 === "\r" || v1 === "\t") return;

						fillValues(row1, colIdx, v1);
					}

					row1 += 1;
				});
			} else if (pasteMultiCol.length > 1) {

				var col2 = colIdx;

				$.each(pasteMultiCol, function (i3, v3) {
					if (v3 === "\n" || v3 === "\r\n" || v3 === "\r" || v3 === "\t") return;

					fillValues(rowIdx, col2, v3);

					col2 += 1;
				});
			} else {

				if (e === "\n" || e === "\r\n" || e === "\r" || e === "\t") return;

				fillValues(rowIdx, colIdx, e);
			}

			element.DataTable().columns.adjust();
		});

		function fillValues(rowIndex, colIndex, val) {
			val = !val ? "" : val;
			val = val.trim().replace("\r\n|\r|\n|\t", "");

			var tdActive = element.find('tbody tr:eq(' + rowIndex + ') td:eq(' + colIndex + ')'),
				thCurrent = element.find('th:eq(' + colIndex + ')'),
				editorID = thCurrent.attr('class').match(/editor-(.*) (.*)/),
				editTag = "editor-input";

			if (!tdActive || tdActive.length == 0) {
				return;
			}

			if (editorID != null && editorID[1]) {
				if ($('#' + editorID[1]).length == 0) { return; }
				editTag = editorID[1];
			}

			if (editTag != "editor-input") { return; }

			if (thCurrent.hasClass('data-type-numeric') && !$.isNumeric(val)) return;

			if (thCurrent.hasClass('data-type-date')) {
				if (!$.isDateValid(val)) return;
				val = val.trim().split(' ')[0];
			}

			if (thCurrent.hasClass('data-type-datetime')) {
				if (!$.isDateValid(val)) return;
				val = val.trim().split(' ').length > 1 ? val.trim() : val.trim() + " 00:00:00";
			}

			if ((thCurrent.hasClass('data-type-date') || thCurrent.hasClass('data-type-datetime')) && !$.isDateValid(val)) return;
			element.DataTable().cell(tdActive).data(val);
			tdActive.trigger("change");
			// tdActive.focus();
			return true;
		};
	});

};

$.fn.editableTableWidget.defaultOptions = {
	cloneProperties: ['padding', 'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
		'text-align', 'font', 'font-size', 'font-family', 'font-weight',
		'border', 'border-top', 'border-bottom', 'border-left', 'border-right'],
	editor: $('<input>')
};

