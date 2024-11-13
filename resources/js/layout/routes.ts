export function sideBarRoutes() {
    return [
        {
            title: "Dashboard",
            icon: "icon-grid",
            name: "dashboard",
            roles: ["User", "Super Admin", "Admin"],
        },
        {
            title: "Events",
            icon: "mdi mdi-calendar",
            name: "events",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "Email Templates",
            icon: "mdi mdi-email",
            name: "email-templates",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "SMS Templates",
            icon: "mdi mdi-email",
            name: "sms-templates",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "Members",
            icon: "mdi mdi-account-multiple",
            name: "members",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "Attendance",
            icon: "mdi mdi-marker-check",
            name: "attendance",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "Follow-up Committee",
            icon: "mdi mdi-account-multiple",
            name: "committee",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "Admins",
            icon: "mdi mdi-account",
            name: "admins",
            roles: ["Super Admin", "Admin"],
        },
        {
            title: "Custom Messages",
            icon: "mdi mdi-email",
            name: "custom-messages",
            roles: ["Super Admin", "Admin"],
        },
    ];
}
