<template>
    <Navbar />
    <div class="history-component">
        <h1 class="title">История посещений</h1>
        <div class="history-tables">
            <table>
                <caption>История сессии</caption>
                <thead>
                <tr>
                    <th>Путь</th>
                    <th>Количество посещений</th>
                </tr>
                </thead>
                <tbody id="sessionHistoryTableBody"></tbody>
            </table>
            <table>
                <caption>История за всё время</caption>
                <thead>
                <tr>
                    <th>Путь</th>
                    <th>Количество посещений</th>
                </tr>
                </thead>
                <tbody id="overallHistoryTableBody"></tbody>
            </table>
        </div>
    </div>
</template>

<script>
import '@/sass/HistoryComponent.scss';
import { getCookie } from '@src/Utils/historyFunctions';
import Navbar from "@src/Components/Navbar.vue";

export default {
    name: 'History',
    components: {
        Navbar
    },

    mounted() {
        const sessionHistoryJSON = localStorage.getItem('sessionHistory');
        const overallHistoryJSON = getCookie('overallHistory');

        const sessionHistoryTableBody = document.getElementById('sessionHistoryTableBody');
        const overallHistoryTableBody = document.getElementById('overallHistoryTableBody');

        sessionHistoryTableBody.innerHTML = '<tr><td colspan="2">Нет данных для отображения</td></tr>';
        overallHistoryTableBody.innerHTML = '<tr><td colspan="2">Нет данных для отображения</td></tr>';

        if (sessionHistoryJSON) {
            const sessionHistory = JSON.parse(sessionHistoryJSON);
            this.fillHistoryTable(sessionHistory, sessionHistoryTableBody);
        }
        
        if (overallHistoryJSON) {
            const overallHistory = JSON.parse(overallHistoryJSON);
            this.fillHistoryTable(overallHistory, overallHistoryTableBody);
        }
    },
    methods: {
        fillHistoryTable(history, tableBody) {
            tableBody.innerHTML = '';
          
            Object.entries(history).forEach(([path, visits]) => {
                const row = document.createElement('tr');

                const pathCell = document.createElement('td');
                pathCell.textContent = path;

                const visitsCell = document.createElement('td');
                visitsCell.textContent = visits;
            
                row.appendChild(pathCell);
                row.appendChild(visitsCell);
            
                tableBody.appendChild(row);
            });
        }
    },
}
</script>