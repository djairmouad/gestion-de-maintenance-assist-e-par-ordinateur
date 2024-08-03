# Gestion de Maintenance Assistée par Ordinateur (GMAO)

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP (using libraries such as PHPMailer and TCPDF)
- **Database**: SQL

This project is a **Computerized Maintenance Management System (CMMS)**, known in French as **Gestion de Maintenance Assistée par Ordinateur (GMAO)**. It is designed to streamline and optimize the management of maintenance activities within a company, helping to reduce downtime and improve overall productivity.

## Features

### 📌 Project Overview
The GMAO system allows companies to efficiently plan, track, and manage maintenance activities. Key functionalities include:

- **User Management**: Admin can create, delete, and update accounts for different roles.
- **Team Assignment**: Admin can assign teams to different maintenance departments (Electric, Hydraulic, IT, Mechanical).
- **Intervention Requests**: Technical agents can submit various types of intervention requests (preventive, systematic, curative) to maintenance managers.
- **Reporting and Archiving**: Teams report the status of interventions, which can be archived or escalated if issues arise.
- **Statistical Analysis**: Admin can view statistics on the number of workers and the number of intervention requests.

### 👨🏻‍💻 Administration
- **Account Management**: Create, delete, and update accounts for different roles, such as:
  - Maintenance Director
  - Production Director
  - Department Boss (Electric, Hydraulic, IT, Mechanical)
- **Team Assignment**: Assign teams to the Maintenance Director.
- **Statistics**: View stats on workers and intervention requests.
- **Administration Code**: Generate an administration code for linking agents with their respective departments.

### 👨🏻‍🔧 Agent
- **Account Creation**: Create an account and link it to the administration using the provided code.
- **Intervention Requests**: Submit intervention requests to the maintenance manager.
- **Profile Management**: Modify personal profile information.

### 👷 Maintenance Director
- **Request Management**: Receive and manage requests from technical agents, and forward them to the production manager.
- **Report Handling**: Receive reports from teams and decide on archiving or problem-solving.
- **Profile Management**: Modify personal profile information.

### 👨‍💼 Production Director
- **Order Issuance**: Issue intervention orders to teams based on requests from the maintenance manager.
- **Profile Management**: Modify personal profile information.

### ⚙️ Department Boss (Electric, Hydraulic, IT, Mechanical)
- **Task Execution**: Receive intervention orders, carry out tasks, and send reports to the maintenance manager.
- **Profile Management**: Modify personal profile information.

## How to Get Started

1. Clone the repository.
2. Set up the database using the provided MySQL  scripts.
3. Configure the backend settings in PHP.
4. Run the application on a local server.

## Contributions

Contributions are welcome! Feel free to submit a pull request or open an issue if you find any bugs or have suggestions for new features.

## License

This project is licensed under the MIT License.

---

