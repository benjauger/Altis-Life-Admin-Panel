/**
 * Created by Benjamin on 03/01/2016.
 */


// Maj licenses player
function updateCivlicenses(type, pid, id) {
    var request = $.ajax({
        url: "/ajax/ajax.php?op=update_civ_licenses",
        method: "POST",
        data: {status: type, pid: pid, id: id},
        dataType: "json"
    });

    // It's okay
    request.done(function (msg) {
        console.log(msg);
        if(msg.status == 1){
            console.log('Add action');
            $('#'+msg.id+'_'+msg.pid).attr('onclick', "updateCivlicenses('"+msg.status+"','"+msg.pid+"','"+msg.id+"')");
            $('#'+msg.id+'_'+msg.pid).removeClass("btn-default");
            $('#'+msg.id+'_'+msg.pid).addClass("btn-danger");
            $('#'+msg.id+'_'+msg.pid).html('Remove');
        }else{
            console.log('Remove action');
            $('#'+msg.id+'_'+msg.pid).attr('onclick', "updateCivlicenses('"+msg.status+"','"+msg.pid+"','"+msg.id+"')");
            $('#'+msg.id+'_'+msg.pid).removeClass("btn-danger");
            $('#'+msg.id+'_'+msg.pid).addClass("btn-default");
            $('#'+msg.id+'_'+msg.pid).html('Add');
        }
    });

    // It's fail
    request.fail(function (jqXHR, textStatus) {
        console.log("Request failed : " + textStatus);
    });

    return false;
}

// Delete vehicle
function deleteVehicle(id) {
    var request = $.ajax({
        url: "/ajax/ajax.php?op=delete_vehicle",
        method: "POST",
        data: {id: id},
        dataType: "json"
    });

    // It's okay
    request.done(function (msg) {
        console.log(msg);
        if(msg.status == "ok"){
            console.log('Delete vehicle #'+msg.id+' action');
            $('#vehicle_'+msg.id).fadeOut(150);
        }
    });

    // It's fail
    request.fail(function (jqXHR, textStatus) {
        console.log("Request failed : " + textStatus);
    });

    return false;
}

// Bootstrap
$(function () {
    $('[data-toggle="tooltip"]').tooltip({html: true})
})