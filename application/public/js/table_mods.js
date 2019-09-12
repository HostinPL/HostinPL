var EditableTable = function () {

    return {

        //main function to initiate the module
        init: function () {		
		   function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }
            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input type="text" class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="text" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
				jqTds[3].innerHTML = '<a class="edit" href="">Сохранить</a>';
                jqTds[4].innerHTML = '<a class="cancel" href="">Отменить</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
				if(jqInputs[0].value == '' || jqInputs[1].value == '' || jqInputs[2].value == ''){
					toastr.info('Заполните все поля!');
					return 0;
				}else{			
					oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
					oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
					oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
					if(edit_table == 'no'){
						oTable.fnUpdate('<a class="edit" onclick="edit_table = '+i_table+';" href="">Редактировать</a>', nRow, 3, false);
						oTable.fnUpdate('<a class="delete" onclick="edit_table = '+i_table+';" href="">Удалить</a>', nRow, 4, false);
					}else{
						oTable.fnUpdate('<a class="edit" onclick="edit_table = '+edit_table+';" href="">Редактировать</a>', nRow, 3, false);
						oTable.fnUpdate('<a class="delete" onclick="edit_table = '+edit_table+';" href="">Удалить</a>', nRow, 4, false);
					}
					
					oTable.fnDraw();
					
					if(edit_table == 'no'){
						data_table[i_table] = {name: jqInputs[0].value, for_ver: jqInputs[1].value, link: jqInputs[2].value};
						i_table++;
					}else{
						data_table[edit_table] = {name: jqInputs[0].value, for_ver: jqInputs[1].value, link: jqInputs[2].value};
						edit_table = 'no';
					}
					
					
					//console.log(data_table);
					return 1;
				}
				
            }
            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                //oTable.fnUpdate('<a class="edit" href="">Редактировать</a>', nRow, 3, false);
                oTable.fnDraw();
            }

            var oTable = $('#editable-sample').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 50,
                "sDom": "",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

			jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown

            var nEditing = null;
			
            $('#editable-sample_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                        '<a class="edit" href="">Редактировать</a>', '<a class="cancel" data-mode="new" href="">Отменить</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });
			$("#editable-sample").on('click', 'a.delete', function(e){
            //$('#editable-sample a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Вы уверены?") == false) {
                    return;
                }
				console.log(this);
                var nRow = $(this).parents('tr')[0];			
                oTable.fnDeleteRow(nRow);
				
				delete data_table[edit_table];
				edit_table = 'no';
            });
			$("#editable-sample").on('click', 'a.cancel', function(e){
           // $('#editable-sample a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });
			$("#editable-sample").on('click', 'a.edit', function(e){
           // $('#editable-sample a.edit').live('click', function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Сохранить") {
                    /* Editing this row and want to save it */
                    var test1 = saveRow(oTable, nEditing);
					if(test1 == 1) nEditing = null;
                   // alert("Updated! Do not forget to do some ajax to sync with backend :)");
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });

			$("#huy").click(function (e) {
				e.preventDefault();				
				for(file in filess){
					var aiNew = oTable.fnAddData(['', '', '', '','<a class="edit" href="">Редактировать</a>', '<a class="cancel" data-mode="new" href="">Отменить</a>']);
					var nRow = oTable.fnGetNodes(aiNew[0]);
					editRow(oTable, nRow);
					nEditing = nRow;
					
					oTable.fnUpdate(filess[file]['name'], nRow, 0, false);
					oTable.fnUpdate(filess[file]['for_ver'], nRow, 1, false);
					oTable.fnUpdate(filess[file]['link'], nRow, 2, false);
					oTable.fnUpdate('<a class="edit" onclick="edit_table = '+file+';" href="">Редактировать</a>', nRow, 3, false);
					oTable.fnUpdate('<a class="delete" onclick="edit_table = '+file+';" href="">Удалить</a>', nRow, 4, false);			
					oTable.fnDraw();
					
					data_table[i_table] = {name: filess[file]['name'], for_ver: filess[file]['for_ver'], link: filess[file]['link']};
					
					i_table = Number(file)+1;				
				}
			});

			$("#huy2").click(function (e) {
				e.preventDefault();							
				for(file in filess){
					var nRow = $('#file'+file)[0];
					oTable.fnDeleteRow(nRow);			
				}
				for(file in data_table){
					var nRow = $('#file'+file)[0];
					oTable.fnDeleteRow(nRow);							
				}				
			});
			
			}

    };

}();