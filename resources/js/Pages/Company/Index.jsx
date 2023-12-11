import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, Link } from "@inertiajs/react";

import { useState, useEffect } from "react";

import {
    AiFillBackward,
    AiFillFastForward,
    AiFillPlusCircle,
} from "react-icons/ai";

export default function Index({ auth, companies }) {
    const [companiesData, setCompaniesData] = useState(companies ?? []);

    const getCompanies = (page = 1) => {
        router.get("/company/list", { page });
    };

    useEffect(() => {}, []);

    return (
        <AuthenticatedLayout
            user={auth?.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Index
                </h2>
            }
        >
            <Head title="Company Index" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="w-full p-5 justify-center bg-slate-300 flex">
                            <Pagination
                                response={companies}
                                getListMethod={getCompanies}
                            />
                            <Link
                                className="flex px-2 py-3 rounded-2xl bg-blue-400"
                                href={route("company-form")}
                            >
                                <AiFillPlusCircle className="my-auto" />
                                <span className="mx-2">Company</span>
                            </Link>
                        </div>
                        <CompanyTable companies={companiesData} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

const CompanyTable = ({ companies }) => {
    return (
        <div className="relative overflow-x-auto p-5">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" className="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" className="px-6 py-3">
                            Logo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {companies.data &&
                        companies.data.map((company) => {
                            return (
                                <tr
                                    className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    key={company?.id}
                                >
                                    <td className="px-6 py-4">{company?.id}</td>
                                    <th
                                        scope="row"
                                        className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {company?.name}
                                    </th>
                                    <td className="px-6 py-4">
                                        {company?.email}
                                    </td>
                                    <td className="px-6 py-4">
                                        {company?.logo ? (
                                            <img
                                                className="h-auto max-w-full max-h-20"
                                                src={company?.logo}
                                                alt="company logo"
                                            />
                                        ) : (
                                            <img
                                                className="h-auto max-w-full max-h-20"
                                                src={
                                                    "/storage/logo/company-default.jpg"
                                                }
                                                alt="default company logo"
                                            />
                                        )}
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
