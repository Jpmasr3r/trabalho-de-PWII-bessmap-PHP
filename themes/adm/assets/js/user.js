import Admin from "../../../_assets/js/Admin.js";

async function fetchAndRenderData() {
	try {
		const admin = new Admin();
		const usersData = await admin.getUsers();
		const teamsData = await admin.getTeams();

		if (usersData.type === "error" || teamsData.type === "error") {
			window.location.href = "http://localhost/trabalho-de-PWII-bessmap-PHP/";
			return;
		}

		if (usersData.type === "success" && teamsData.type === "success") {
			const users = usersData.data;
			const teams = teamsData.data;

			const divArea = document.getElementById("div-area");

			teams.forEach((team) => {
				const teamContainer = document.createElement("div");
				teamContainer.classList.add("team-container");

				const divTeamInfo = document.createElement("div");
				divTeamInfo.classList.add("div-team-info");

				const teamTitle = document.createElement("h1");
				teamTitle.textContent = team.name;

				const teamInfo = document.createElement("p");
				teamInfo.textContent = `Informações sobre ${team.name}.`;

				divTeamInfo.appendChild(teamTitle);
				divTeamInfo.appendChild(teamInfo);

				const divTeamMembers = document.createElement("div");
				divTeamMembers.classList.add("div-team-members");

				const teamMembersTitle = document.createElement("h1");
				teamMembersTitle.textContent = `Membros do ${team.name}`;

				divTeamMembers.appendChild(teamMembersTitle);

				users.forEach((user) => {
					if (user.team_id === team.id) {
						const teamMember = document.createElement("div");
						teamMember.classList.add("team-member");

						const memberImg = document.createElement("img");
						memberImg.src = user.image
							? user.image
							: "<?= url('themes/_assets/imgs/bee-black.png') ?>";
						memberImg.alt = `Foto do ${user.name}`;

						const memberInfo = document.createElement("div");
						memberInfo.classList.add("team-member-info");

						const memberName = document.createElement("h1");
						memberName.textContent = user.name;

						memberInfo.appendChild(memberName);
						teamMember.appendChild(memberImg);
						teamMember.appendChild(memberInfo);
						divTeamMembers.appendChild(teamMember);
					}
				});

				teamContainer.appendChild(divTeamInfo);
				teamContainer.appendChild(divTeamMembers);
				divArea.appendChild(teamContainer);
			});

			// Cria área para usuários sem equipe
			const noTeamContainer = document.createElement("div");
			noTeamContainer.classList.add("team-container");

			const noTeamInfo = document.createElement("div");
			noTeamInfo.classList.add("div-team-info");

			const noTeamTitle = document.createElement("h1");
			noTeamTitle.textContent = "Usuários sem equipe";

			noTeamInfo.appendChild(noTeamTitle);
			noTeamContainer.appendChild(noTeamInfo);

			const noTeamMembers = document.createElement("div");
			noTeamMembers.classList.add("div-team-members");

			const noTeamMembersTitle = document.createElement("h1");
			noTeamMembersTitle.textContent = "Usuários sem equipe";

			noTeamMembers.appendChild(noTeamMembersTitle);

			users.forEach((user) => {
				if (!user.team_id) {
					const teamMember = document.createElement("div");
					teamMember.classList.add("team-member");

					const memberImg = document.createElement("img");
					memberImg.src = user.image
						? user.image
						: "<?= url('themes/_assets/imgs/bee-black.png') ?>";
					memberImg.alt = `Foto do ${user.name}`;

					const memberInfo = document.createElement("div");
					memberInfo.classList.add("team-member-info");

					const memberName = document.createElement("h1");
					memberName.textContent = user.name;

					memberInfo.appendChild(memberName);
					teamMember.appendChild(memberImg);
					teamMember.appendChild(memberInfo);
					noTeamMembers.appendChild(teamMember);
				}
			});

			noTeamContainer.appendChild(noTeamMembers);
			divArea.appendChild(noTeamContainer);
		}
	} catch (error) {
		console.error("Erro ao buscar dados da API:", error);
		window.location.href = "http://localhost/trabalho-de-PWII-bessmap-PHP/";
	}
}

fetchAndRenderData();
