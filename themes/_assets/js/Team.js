import Notification from "./Notification.js";

class Team {
    name;
    team_members;

    constructor(name = "") {
        this.setName(name);
    }

    //setter
    setName(name) {
        this.name = name;
    }

    setTeamMembers(team_members) {
        this.team_members = team_members;
    }

    //getter
    getName() {
        return this.name;
    }

    getTeam_members() {
        return this.team_members;
    }

    getFormData() {
        const formData = new FormData();
        formData.append("name",this.getName());
        formData.append("team_members",this.getTeam_members());
        return formData;
    }

    //functions
    async insert() {
        try {
            let data = await fetch("http://localhost/beesmap/api/teams",{
                method: "POST",
                body: this.getFormData(),
                headers: {
                    token: localStorage.getItem("token")
                }
            }).then((res) => res.json());
            
            return data;
        } catch (error) {
            return {
                type: "error",
                message: error,
            }
        }
    }

    async join() {
        try {
            let data = await fetch(`http://localhost/beesmap/api/teams/join`,{
                method: "POST",
                body: this.getFormData(),
                headers: {
                    token: localStorage.getItem("token")
                }
            }).then((res) => res.json());

            new Notification(
                data.message,
                data.type,
            )

            return data;
        } catch (error) {
            return {
                type: "error",
                message: error,
            }
        }
    }

    async update() {
        try {
            let data = await fetch("http://localhost/beesmap/api/teams/update",{
                method: "PUT",
                body: this.getFormData(),
                headers: {
                    token: localStorage.getItem("token")
                }
            }).then((res) => res.json());

            return data;
        } catch (error) {
            return {
                type: "error",
                message: error,
            }
        }
    }

    async delete() {
        try {
            let data = await fetch("http://localhost/beesmap/api/teams/delete",{
                method: "DELETE",
                headers: {
                    token: localStorage.getItem("token")
                }
            }).then((res) => res.json());

            return data;
        } catch (error) {
            return {
                type: "error",
                message: error,
            }
        }
    }

    async getInfs() {
        try {
            let data = await fetch("http://localhost/beesmap/api/teams/getInfs",{
                method: "GET",
                headers: {
                    token: localStorage.getItem("token")
                }
            }).then((res) => res.json());
    
            return data;
        } catch (error) {
            return {
                type: "error",
                message: error,
            }
        }
    }

    async getAllTeamsByName(name = "") {
        try {
            let data = await fetch(`http://localhost/beesmap/api/teams/getTeams/${name}`,{
                method: "GET",
                headers: {
                    token: localStorage.getItem("token")
                }
            }).then((res) => res.json());
    
            return data;
        } catch (error) {
            return {
                type: "error",
                message: error,
            }
        }
    }

    async exit() {
        try {
            let data = await fetch(`http://localhost/beesmap/api/teams/exit`,{
                method: "POST",
                headers: {
                    token: localStorage.getItem("token")
                }
            }).then((res) => res.json());

            new Notification(
                data.message,
                data.type,
            );

            return data;
        } catch (error) {
            new Notification(
                error,
                "error",
            );

            return {
                type: "error",
                message: error,
            }
        }
    }

}

export default Team;