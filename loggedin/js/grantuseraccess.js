$(function () {
    $("body").on("click", ".listItem", function () {
        $(".listItem").not(this).removeClass("selected");
        $(this).toggleClass("selected");
    });
    $("#grantAccessButton").click(function () {
        if ($(".member.selected").length > 0) {
            var id = $(".member.selected").attr("memberid");
            var name = $(".member.selected").attr("fullname");
            if (confirm("Are you sure you want to grant " + name + " COB Admin Access")) {
            /*  
                $.ajax({
                    url:"https://e-solutionsgroup.com:8080/api/Account/UserInfo?userId="+id,
                    crossDomain:true,
                    dataType:'json',
                    cache:false,
                    contentType:"application/json; charset=utf-8",
                    beforeSend:function(xhr){
                        xhr.setRequestHeader("Authorization","Bearer "+token);
                    },
                    success:function(data){  
                        alert(data.FirstName+data.LastName+data.HasRegistered);
                    }
                }); */

               $.ajax({
                    url: "https://e-solutionsgroup.com:8080/api/Account?userID="+id+"&role=COBAdmin",
                    crossDomain: true,
                    dataType: 'json',
                    cache: false,
                    contentType: "application/json; charset=utf-8",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function (data) {
                        alert(name + "was successfully granted COB Admin Access");
                    },
                    error: function (err) {
                        alert("There was an error completing this operation, please try again later");
                    }
                });
            }
        }
    });

    $.ajax({
        url: "https://e-solutionsgroup.com:8080/api/AllCOBSecurityReivews",
        crossDomain: true,
        dataType: 'json',
        cache: false,
        contentType: "application/json; charset=utf-8",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            console.log(data);
            for (i = 0; i < data.length; i++) {
                //Display Admin Accounts Only
                /*    for(index in data[i].Roles){
                        if(data[i].Roles[index].RoleId === "c8c80826-0f70-499c-b529-d2ed69d190ff"){
                            $("<div></div>")
                                .addClass("listItem member")
                                .attr("memberid",data[i].Id)
                                .append(
                                    $("<div></div>")
                                        .addClass("firstName")
                                        .text(data[i].FirstName),
                                    $("<div></div>")
                                        .addClass("lastName")
                                        .text(data[i].LastName),
                                    $("<div></div>")
                                        .addClass("email")
                                        .text(data[i].Email)
                                )
                            .appendTo("#memberList");
                        }
                    }*/

                //Display accounts with @cobcreditunion emails only
                var allowedEmail = "@cobcreditunion.com";
                if (data[i].User.Email.includes(allowedEmail)) {
                    $("<div></div>")
                        .addClass("listItem member")
                        .attr("memberid", data[i].User.Id)
                        .attr("fullname", data[i].User.FirstName + " " + data[i].User.LastName)
                        .append(
                            $("<div></div>")
                            .addClass("firstName")
                            .text(data[i].User.FirstName),
                            $("<div></div>")
                            .addClass("lastName")
                            .text(data[i].User.LastName),
                            $("<div></div>")
                            .addClass("email")
                            .text(data[i].User.Email)
                        )
                        .appendTo("#memberList");
                }
            }
        }
    });
});




/* $.ajax({
    url: "https://e-solutionsgroup.com:8080/api/Account/UsersBySourceInstitution?institutionId=8DB34F14-A886-4BDB-AC85-2351CDD0F715",
    crossDomain: true,
    dataType: 'json',
    cache: false,
    contentType: "application/json; charset=utf-8",
    beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", "Bearer " + token);
    },
    success: function (data) {
        console.log(data);
        for (i = 0; i < data.length; i++) {
            //Display accounts with @cobcreditunion emails only
            var allowedEmail = "@cobcreditunion.com";
            if (data[i].Email.includes(allowedEmail)) {
                $("<div></div>")
                    .addClass("listItem member")
                    .attr("memberid", data[i].Id)
                    .attr("fullname", data[i].FirstName + " " + data[i].LastName)
                    .append(
                        $("<div></div>")
                        .addClass("firstName")
                        .text(data[i].FirstName),
                        $("<div></div>")
                        .addClass("lastName")
                        .text(data[i].LastName),
                        $("<div></div>")
                        .addClass("email")
                        .text(data[i].Email)
                    )
                    .appendTo("#memberList");
            }
        }
    }
}); */