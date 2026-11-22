<script setup>
import { ref, onMounted } from 'vue'
import { API_URL } from './config'

const section = ref('emp')
const employees = ref([])
const customers = ref([])
const msg = ref('')
const empForm = ref({ emp_code: '', full_name: '', position: '', phone: '', salary: '' })
const custForm = ref({ customer_name: '', phone: '', email: '', province: '' })

const loadAll = async () => {
  const [er, cr] = await Promise.all([fetch(`${API_URL}/employees.php`), fetch(`${API_URL}/customers.php`)])
  employees.value = (await er.json()).data || []
  customers.value = (await cr.json()).data || []
}

const addEmp = async () => {
  const r = await fetch(`${API_URL}/employees.php`, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(empForm.value) })
  msg.value = (await r.json()).message
  empForm.value = { emp_code: '', full_name: '', position: '', phone: '', salary: '' }
  await loadAll()
}

const delEmp = async (id) => {
  const r = await fetch(`${API_URL}/employees.php`, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ action: 'delete', emp_id: id }) })
  msg.value = (await r.json()).message
  await loadAll()
}

const addCust = async () => {
  const r = await fetch(`${API_URL}/customers.php`, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(custForm.value) })
  msg.value = (await r.json()).message
  custForm.value = { customer_name: '', phone: '', email: '', province: '' }
  await loadAll()
}

const delCust = async (id) => {
  const r = await fetch(`${API_URL}/customers.php`, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ action: 'delete', customer_id: id }) })
  msg.value = (await r.json()).message
  await loadAll()
}

onMounted(loadAll)
</script>

<template>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container">
      <span class="navbar-brand">ระบบจัดการพนักงานและลูกค้า</span>
      <ul class="nav nav-pills">
        <li class="nav-item"><button class="nav-link btn-sm text-white" :class="{ active: section === 'emp' }" @click="section = 'emp'">พนักงาน</button></li>
        <li class="nav-item"><button class="nav-link btn-sm text-white" :class="{ active: section === 'cust' }" @click="section = 'cust'">ลูกค้า</button></li>
      </ul>
    </div>
  </nav>
  <div class="container my-4">
    <div v-if="msg" class="alert alert-success py-2">{{ msg }}</div>
    <div v-if="section === 'emp'">
      <form class="row g-2 mb-3" @submit.prevent="addEmp">
        <div class="col-md-2"><input v-model="empForm.emp_code" class="form-control form-control-sm" placeholder="รหัส" required /></div>
        <div class="col-md-3"><input v-model="empForm.full_name" class="form-control form-control-sm" placeholder="ชื่อ-นามสกุล" required /></div>
        <div class="col-md-2"><input v-model="empForm.position" class="form-control form-control-sm" placeholder="ตำแหน่ง" required /></div>
        <div class="col-md-2"><input v-model="empForm.phone" class="form-control form-control-sm" placeholder="เบอร์โทร" /></div>
        <div class="col-md-2"><input v-model="empForm.salary" type="number" class="form-control form-control-sm" placeholder="เงินเดือน" /></div>
        <div class="col-md-1"><button class="btn btn-primary btn-sm w-100">เพิ่ม</button></div>
      </form>
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-secondary"><tr><th>รหัส</th><th>ชื่อ-นามสกุล</th><th>ตำแหน่ง</th><th>เบอร์โทร</th><th class="text-end">เงินเดือน</th><th class="text-center">ลบ</th></tr></thead>
        <tbody>
          <tr v-for="e in employees" :key="e.emp_id">
            <td>{{ e.emp_code }}</td><td>{{ e.full_name }}</td><td>{{ e.position }}</td><td>{{ e.phone }}</td>
            <td class="text-end">{{ Number(e.salary).toLocaleString() }}</td>
            <td class="text-center"><button class="btn btn-danger btn-sm" @click="delEmp(e.emp_id)">ลบ</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <form class="row g-2 mb-3" @submit.prevent="addCust">
        <div class="col-md-3"><input v-model="custForm.customer_name" class="form-control form-control-sm" placeholder="ชื่อลูกค้า" required /></div>
        <div class="col-md-2"><input v-model="custForm.phone" class="form-control form-control-sm" placeholder="เบอร์โทร" required /></div>
        <div class="col-md-3"><input v-model="custForm.email" type="email" class="form-control form-control-sm" placeholder="อีเมล" /></div>
        <div class="col-md-3"><input v-model="custForm.province" class="form-control form-control-sm" placeholder="จังหวัด" /></div>
        <div class="col-md-1"><button class="btn btn-primary btn-sm w-100">เพิ่ม</button></div>
      </form>
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-secondary"><tr><th>ID</th><th>ชื่อลูกค้า</th><th>เบอร์โทร</th><th>อีเมล</th><th>จังหวัด</th><th class="text-center">ลบ</th></tr></thead>
        <tbody>
          <tr v-for="c in customers" :key="c.customer_id">
            <td>{{ c.customer_id }}</td><td>{{ c.customer_name }}</td><td>{{ c.phone }}</td><td>{{ c.email }}</td><td>{{ c.province }}</td>
            <td class="text-center"><button class="btn btn-danger btn-sm" @click="delCust(c.customer_id)">ลบ</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
