<template>
  <div>

    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="/">Bon Matin Docteur</a>

      <button class="navbar-toggler align-left" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample01">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">View Appointments <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/scheduleAppointment">Schedule an Appointment</a>
          </li>
          <li class="nav-item" href="/">
            <cart></cart>
          </li>
          <li class="nav-item" href="/">
            <a class="nav-link" href="/">Log out</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
  import Cart from './Cart.vue';
  export default {
    components: {
      'cart': Cart
    }
  };
</script>
