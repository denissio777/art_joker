    $('#registration').submit(function(e) {
        e.preventDefault();
        let name = $('#name').val();
        let email = $('#email').val();
        let select = $('#select').val();
        let selectCity = $('#selectCity').val();

        $(".error").remove();

        if (name.length < 5) {
            $('#name').after('<span class="error">Full name must contain at least 5 letters</span>');
        }
        if (email.length < 5) {
            $('#email').after('<span></span>');
        }
        if (!select) {
            $('#select').after('<span class="error">Chose your state please</span>');
        }
        if (!selectCity) {
            $('#selectCity').after('<span class="error">Chose your city please</span>');
        }
    });

$.get('../model/db.php',
    function (response) {
        for (let n = 0; n <= 26; n++) {
            let region = response[n].ter_name;
            window.regionId = response[n].reg_id;
            $('#select').append($('<option></option>') .attr('value', window.regionId).text(region));
        }
        $(".chosen-select").chosen({width: "35%"});
    });

function getCities() {
    $('#selectCity').find("option").remove();
    $('#selectCity').append('<option></option>');
    $('.chosen-select2').chosen("destroy");
    $('#selectCityWrap').css('display', '');
    window.catched = $('#select').val();
    $.get('../model/db_city.php?catched=' + window.catched,
        function (data) {
            let y = window.regionId;
            for (let x = 0; x <= y; x++) {
                let regionCity = data[x].ter_address;
                let regionCityId = data[x].reg_id;
                $('#selectCity').append($('<option></option>') .attr('value', regionCityId).text(regionCity));
                $(".chosen-select2").chosen({width: "35%"}).trigger("chosen:updated");
            }
        });
}

function getDistricts() {
    $('#selectDistrict').find("option").remove();
    $('#selectDistrict').append('<option></option>');
    $('.chosen-select3').chosen("destroy");
    $('#selectDistrictWrap').css('display', '');
    $.get('../model/db_district.php?catched=' + window.catched,
        function (data) {
            let y = window.regionId;
            for (let x = 0; x <= y; x++) {
                let regionDistrict = data[x].ter_address;
                let regionDistrictId = data[x].reg_id;
                $('#selectDistrict').append($('<option></option>') .attr('value', regionDistrictId).text(regionDistrict));
                $(".chosen-select3").chosen({width: "35%"}).trigger("chosen:updated");
            }
        });
}

function insert() {
    if ($('#selectDistrict option:selected')[0].text.length < 10){
        window.territory = $('#selectCity option:selected')[0].text;
    } else if ($('#selectDistrict option:selected')[0].text.length > 10){
        window.territory = $('#selectDistrict option:selected')[0].text;
    }
    console.log(window.territory);
    $('#tr td').find("p").remove();
    let name = $('#name').val();
    let email = $('#email').val();
    $.get('../model/db_insert.php?catched=' + window.catched + '&territory=' + window.territory + '&name=' + name + '&email=' + email,
        function (data) {
                $('#table').css('display', '');
                $('#tr td').append('<p></p>');
                let resName = (data[0].name);
                let resEmail = (data[0].email);
                let resTerritory = (data[0].territory);

                let nodeForName = document.createElement("p");
                let textNodeForName = document.createTextNode(resName);
                nodeForName.appendChild(textNodeForName);
                document.getElementById("forName").appendChild(nodeForName);

                let nodeForEmail = document.createElement("p");
                let textNodeForEmail = document.createTextNode(resEmail);
                nodeForEmail.appendChild(textNodeForEmail);
                document.getElementById("forEmail").appendChild(nodeForEmail);

                let nodeForTerritory = document.createElement("p");
                let textNodeForTerritory = document.createTextNode(resTerritory);
                nodeForTerritory.appendChild(textNodeForTerritory);
                document.getElementById("forTerritory").appendChild(nodeForTerritory);
            }
        )
}