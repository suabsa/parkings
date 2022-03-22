<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parkings</title>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!--Bootstrap part!-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mx-auto" id="app">
    <h2>Parking Information Application</h2>
    <form @submit.prevent="getSearchResults">
        <div class="form-group">
            <label for="formGroupCountry">Country</label>
            <input type="text" class="form-control" v-model="formGroupCountry" id="formGroupCountry"
                   placeholder="Country">
            <div class="feedback text-info">For Testing use: Finland</div>
        </div>
        <div class="form-group">
            <label for="formGroupOwner">Owner</label>
            <input type="text" class="form-control" id="formGroupOwner" v-model="formGroupOwner" placeholder="Owner">
            <div class="feedback text-info">For Testing use: AutoPark</div>
        </div>
        <div class="form-group">
            <label for="formGroupPoint">Geo Location</label>
            <input type="text" class="form-control" v-model="formGroupPoint" id="formGroupPoint"
                   placeholder="Geo Location">
            <div class="feedback text-info">For Testing use: 60.165219358852795 24.93537425994873</div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <table class="table">
        <tbody>
        <tr v-for="(row,rid) in getGarages">
            <td>{{row}}</td>
        </tr>
        </tbody>
    </table>
</div>

<script>
    Vue.createApp({
        data() {
            return {
                garages: {}
            };
        },
        computed: {
            getGarages: function () {
                //Some issues with props object
                return JSON.parse(JSON.stringify(Object.assign({}, this.garages)))
            }
        },
        methods: {
            //Ajax Request to the controller. Make it as simple as possible at this point
            getSearchResults: function (event) {
                axios.post('controller/ControllerIndex.php',
                    {country: this.formGroupCountry, owner: this.formGroupOwner, point: this.formGroupPoint}
                ).then(response => (this.garages = (response.data.garages)))
            }
        }
    }).mount('#app');
</script>
</body>
</html>