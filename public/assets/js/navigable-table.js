/** 
 * @param {string} tableId - Navigable table's Id.
 * @param {string} containerId - The index of the cell to be when table loads.
 * @param {string} campoId - Focus the Navigable table when body loads.
 * @param {string} campoTexo - Focus the Navigable table when body loads.
*/

function makeNavigable(tableId, containerId, campoId, campoTexto) {

    var isTableActive = false;
    $(document).ready(function() {
        
        // every time that there's a click on the page, it will detect if it was on the table or outside of it
        $(document).on("click", function(e) {
            isTableActive = $.contains(document.getElementById(tableId), e.target);
        });
        
        // the first row will be active by default
        $("#"+tableId+ " tbody tr:first-child").addClass("ativo");

        // focus the clicked row (no need to scroll because it's visible
        $("#"+tableId+ " tbody tr").on("click", function() {
            $("#"+tableId+ " tbody tr.ativo").removeClass("ativo");
            $(this).addClass("ativo");
            var id = $(this).closest('tr')[0].children[0].innerText;
            var descricao = $(this).closest('tr')[0].children[1].innerText;
            $("#" + campoId).val(id);
            $("#" + campoTexto).val(descricao);
            $("#" +containerId).html('');
        });


        // when a key is pressed
        //$(document).unbind().bind("keyup", function(e) {
        $(document).on("keyup", function(e) {
           
            switch(e.keyCode) {
                case 38: // up
                    if ($("#"+tableId+ " tbody tr.ativo").prev().length) {
                        $("#"+tableId+ " tbody tr.ativo").removeClass("ativo").prev().addClass("ativo");
                    }
                    break;
                case 40: // down
                    if ($("#"+tableId+ " tbody tr.ativo").next().length) {
                        $("#"+tableId+ " tbody tr.ativo").removeClass("ativo").next().addClass("ativo");
                    }
                    break;
                case 13: // enter
                    e.preventDefault();
                    var id =  $("#"+tableId+ " tbody tr.ativo")[0].children[0].innerText;
                    var descricao =  $("#"+tableId+ " tbody tr.ativo")[0].children[1].innerText;
                    $("#" + campoId).val(id);
                    $("#" + campoTexto).val(descricao);
                    $("#" +containerId).html('');
                    pBusca = '';
                    break;
            }

            // the selected element will always be visible on top
            var top = $("#"+tableId+ " tbody tr.ativo");
            if(top.length){                
                top = top.offset().top+ 
                $("#"+tableId+ " tbody").scrollTop() - 
                $("#"+tableId+ " tbody").offset().top;            
            }      
            else{top = 0};      
            $("#" + containerId).scrollTop(top);

            // prevent the scrolling effect if the last active element was the table
            if (isTableActive) {
                e.preventDefault();
                return false;
            }
        });
    });
}