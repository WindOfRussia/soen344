<template>
    <div id="appointments">
        <SortedTable :values="appointments">
            <thead>
            <tr>
                <th scope="col">
                    <SortLink name="doctor">Doctor</SortLink>
                </th>
                <th scope="col">
                    <SortLink name="patient">Patient ID</SortLink>
                </th>
                <th scope="col">
                    <SortLink name="clinic">Clinic</SortLink>
                </th>
                <th scope="col" >
                    <SortLink name="room">Room ID</SortLink>
                </th>
                <th scope="col">
                    <SortLink name="status">Status</SortLink>
                </th>
                <th scope="col" >
                    <SortLink name="date">Date</SortLink>
                </th>
                <th scope="col" />
            </tr>
            </thead>
            <tbody slot="body" slot-scope="sort">
            <tr v-for="appointment in sort.values" :key="appointment.id">
                <td>{{ appointment.doctor["name"] }}</td>
                <td>{{ appointment.patient["id"] }}</td>
                <td>
                    Name: {{ appointment.doctor["clinic"]["name"] }}
                    <br><br>
                    Address: {{ appointment.doctor["clinic"]["address"] }}
                </td>
                <td>{{ appointment.room["id"] }}</td>
                <td>{{ appointment.status }}</td>
                <td>{{ dateFormatter(appointment.start) }}</td>
                <td>
                    <modify-appointment-modal :apmt="appointment"></modify-appointment-modal>
                    <button type="button" class="btn btn-danger" v-on:click="cancelAppointment(appointment.id)" vertical-align="center">Cancel</button></td>
            </tr>
            </tbody>
        </SortedTable>
    </div>
</template>

<script>
    import axios from "axios";
    import moment from "moment";
    import ModifyAppointmentModal from "./ModifyAppointmentModal";
    import { SortedTable, SortLink } from "vue-sorted-table";
    export default {
        name: "ViewAppointments",
        data () {
            return {
                appointments: []
            }
        },
        Components : {
            ModifyAppointmentModal
        },
        mounted() {
            this.getAppointments();
        },
        methods: {
            getAppointments: function() {
                axios.get('/api/appointment')
                    .then(response => {
                        if(response.status == 200) {
                            this.appointments = response.data.data;
                            console.log("getAppointments" + response)
                        } else {
                            console.log("Get appointments failed: Response code " + response.status)
                        }
                    })
            },
            cancelAppointment: function(id) {
                axios.delete('/api/appointment/' + id).then(response => {
                    if(response.status == 200) {
                        console.log("Cancelled appointment : " + id);
                        this.getAppointments();
                    } else {
                        console.log("Cancel appointment failed: Response code " + response.status)
                    }
                })
            },
            dateFormatter: function(date) {
                return moment(date).format("YYYY-MM-DD HH:mm");
            }
        }
    };
</script>
