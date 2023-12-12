import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, Link, usePage } from "@inertiajs/react";

import { useState, useEffect } from "react";

import {
    AiFillBackward,
    AiFillDelete,
    AiFillEye,
    AiFillFastForward,
    AiFillPlusCircle,
} from "react-icons/ai";

import { useAppToast } from "@/utils/toast.util";

export default function EmployeeIndex({ auth, employees }) {
    const [employeesData, setEmployeesData] = useState(employees ?? []);
    const { showToast } = useAppToast();

    const getEmployees = (page = 1) => {
        router.get("/employee/list", { page });
    };

    const deleteEmployee = (employeeId) => {
        try {
            router.delete("/api/employee/delete/" + employeeId);

            router.reload();
            
            showToast({
                title: "Success",
                description: "Updated!",
                status: "success",
            });
            getEmployees()
        } catch (error) {
            console.log(error);
        }
    };

    useEffect(() => {
    }, []);


    return (
        <AuthenticatedLayout
            user={auth?.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Index
                </h2>
            }
        >
            <Head title="Employee Index" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="w-full p-5 justify-center bg-slate-300 flex">
                            <Pagination
                                response={employees}
                                getListMethod={getEmployees}
                            />
                            <Link
                                className="flex px-2 py-3 rounded-2xl bg-blue-400"
                                href={route("employee-form")}
                            >
                                <AiFillPlusCircle className="my-auto" />
                                <span className="mx-2">Employee</span>
                            </Link>
                        </div>
                        <EmployeeTable
                            employees={employeesData}
                            deleteEmployee={deleteEmployee}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

const EmployeeTable = ({ employees, deleteEmployee }) => {
    const handleRowClick = (employeeId) => {};

    return (
        <div className="relative overflow-x-auto p-5">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" className="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" className="px-6 py-3">
                            First Name
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Last Name
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Phone Number
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Company
                        </th>
                        <th scope="col" className="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    {employees.data &&
                        employees.data.map((employee) => {
                            return (
                                <tr
                                    className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-slate-600"
                                    key={employee?.id}
                                >
                                    <td className="px-6 py-4">{employee?.id}</td>
                                    <th
                                        scope="row"
                                        className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {employee?.first_name}
                                    </th>
                                    <th
                                        scope="row"
                                        className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {employee?.last_name}
                                    </th>
                                    <td className="px-6 py-4">
                                        {employee?.email}
                                    </td>
                                    <td className="px-6 py-4">
                                        {employee?.phone_number}
                                    </td>
                                    <td className="px-6 py-4">
                                        {employee?.company?.name}
                                    </td>
                                    <td className="px-6 py-4 flex gap-5 justify-center">

                                        <button className="my-auto">
                                            <AiFillEye
                                                onClick={() => {
                                                    router.visit(
                                                        `/employee/edit/${employee?.id}`
                                                    );
                                                }}
                                            />
                                        </button>

                                        <button>
                                            <AiFillDelete
                                                onClick={() => {
                                                    if (
                                                        window.confirm(
                                                            "Confirm delete?"
                                                        )
                                                    ) {
                                                        deleteEmployee(employee?.id);
                                                    }
                                                }}
                                                style={{ color: "red" }}
                                            />
                                        </button>
                                    </td>
                                </tr>
                            );
                        })}
                </tbody>
            </table>
        </div>
    );
};

const Pagination = ({ response, getListMethod }) => {
    const { current_page, last_page, next_page_url, prev_page_url } = response;

    const pageNumbers = [];
    for (let i = 1; i <= last_page; i++) {
        pageNumbers.push(i);
    }

    const goToPage = (page) => {
        // Implement logic to fetch data for the selected page using the API
        // You can use the page value to fetch data from the API
        console.log(`Fetching data for page ${page}`);
        getListMethod(page);
    };

    return (
        <nav aria-label="Page navigation example" className="mx-auto">
            <ul className="inline-flex -space-x-px text-sm gap-2">
                {prev_page_url && (
                    <li>
                        <button
                            onClick={() => goToPage(current_page - 1)}
                            className="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >
                            <AiFillBackward />
                        </button>
                    </li>
                )}
                {pageNumbers.map((page) => (
                    <li key={page}>
                        <button
                            onClick={() => goToPage(page)}
                            className={`flex items-center justify-center px-3 h-8 leading-tight ${
                                current_page === page
                                    ? "text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                                    : "text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            }`}
                        >
                            {page}
                        </button>
                    </li>
                ))}
                {next_page_url && (
                    <li>
                        <button
                            onClick={() => goToPage(current_page + 1)}
                            className="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >
                            <AiFillFastForward />
                        </button>
                    </li>
                )}
            </ul>
        </nav>
    );
};
